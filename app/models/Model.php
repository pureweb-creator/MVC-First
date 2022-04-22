<?php
/**
 * Main model class
 *
 * @author Roman S. <roman.semenikhin99@gmail.com>
 * @package Model
 */
namespace models;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;

/**
 * Model. Provides a basic CRUD operations and works with database.
 *
 * @author Roman S. <roman.semenikhin99@gmail.com>
 * @package Model
 */
class Model extends Dbh implements ServerRequestInterface
{
    /**
     * Stores HTTP protocol version as a string.
     *
     * @return string HTTP protocol version.
     */
    private $protocolVersion;

    /**
     * Store server parameters.
     * 
     * @var array
     */
    private $serverParams;

    /**
     * Stores the deserialized query string arguments, if any.
     * 
     * @var array
     */
    private $queryParams;

    /**
     * Stores cookies sent by the client to the server.
     * 
     * @var array
     */
    private $cookieParams;

    /**
     * Stores fetched data
     *
     * @param string query
     * 
     * @return array 
     */
    public function render($query): array
    {
        return $query->fetchAll();
    }

    /**
     * Returns json encoded data
     * 
     * @param array data
     * @example Example of usage
     *
     * ```
     * $model = new models\Model();
     * $users = $model->load('user', 'id = ?', [1]);
     * echo $model->makeResponse($users);
     * ```
     *
     * @return string
     */
    public function makeResponse($data): string
    {
        return json_encode($data);
    }

    /**
     * Reads all the data from the selected table
     * 
     * @param string table
     * @example Example of usage
     *
     * ```
     * $model = new Model();
     * $users = $model->loadAll('user');
     * ```
     *
     * @return array
     */
    public function loadAll($table): array
    {
        try{
            $statement = "SELECT * FROM $table";
            $query = $this->connect()->query($statement);

            return $this->render($query);
        } catch (\PDOException $e){
            return $e->getMessage();
        }
    }

    /**
     * Reads selected data from selected table
     * 
     * @param string table
     * @param string where
     * @param array values
     *
     * @example Example of usage
     * <pre>
     * $model = new Model();
     * $model->load('user','id = ?',[1]);
     * </pre>
     * @return array 
     */
    public function load($table, $where, $values): array
    {
        try{
            $query = "SELECT * FROM $table WHERE $where";
            $statement = $this->connect()->prepare($query);
            $statement->execute($values);

            return $this->render($statement);
        } catch (\PDOException $e){
            return [$e->getMessage()];
        }
    }

    /**
     * Load products
     *
     * @param $array
     * @return array
     */
    public function loadProducts($array): array
    {
        $product_ids = "";
        foreach ($array['product_id'] as $item)
            $product_ids .= $item['pid'].",";
        $product_ids = rtrim($product_ids, ", ");
        $product_ids = explode(",", $product_ids);
        $quotations = str_repeat("?, ", count($array['product_id']) - 1) . '?';

        try{
            $query = "SELECT * FROM product WHERE id IN ($quotations)";
            $statement = $this->connect()->prepare($query);
            $statement->execute($product_ids);
        } catch (\PDOException $e){
            return [$e->getMessage()];
        }

        return $this->render($statement);
    }

    /**
     * Removes smth
     *
     * @param $table
     * @param $where
     * @param $values
     * @return array|string
     */
    public function remove($table, $where, $values){
        try{
            $query = "DELETE FROM $table WHERE $where";
            $statement = $this->connect()->prepare($query);
            $statement->execute($values);

            return $query;
        } catch (\PDOException $e){
            return [$e->getMessage()];
        }
    }

    /**
     * Inserts selected data to selected table
     * 
     * @param string table name
     * @param string fields list
     * @param array values
     *
     * @example Example of usage
     * <pre>
     * $model = new Model();
     * $model->create('user', 'name,email,password',['John','test@example.com','123'])
     * </pre>
     * @return string
     */
    public function create($table,$fields,$values): string
    {
        $prepared = "";
        for ($i=0; $i<count($values); $i++){
            $prepared .= "?,"; }
        $prepared = rtrim($prepared, ",");

        try{
            $query = "INSERT INTO $table ($fields) VALUES ($prepared)";
            $statement = $this->connect()->prepare($query);
            $statement->execute($values);

            return $query;

        } catch (\PDOException $e){
            return $e->getMessage();
        }
    }


    /**
     * Updates data in table
     *
     * Makes SQL query from parameters.
     * 
     * @param string table
     * @param string fields
     * @param string where
     * @param string values
     *
     * @example Example of usage
     * <pre>
     * $model = new Model();
     * $model->update('user','name, email','id = ?',[2]);
     * </pre>
     * 
     * @return string
     */
    public function update($table,$fields,$where,$values): string
    {
       try{
           $query = "UPDATE $table SET $fields WHERE $where";
           $statement = $this->connect()->prepare($query);
           $statement->execute($values);

           return $query;
       } catch (\PDOException $e){
           return $e->getMessage();
       }
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * @return string
     */
    public function getProtocolVersion(): string
    {
        $serverParams = $this->getServerParams();
        $v = explode("/", $serverParams['SERVER_PROTOCOL']);
        
        return $v[1];
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * @param string $version
     * @return static
     */
    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    /**
     * Retrieves all message header values.
     * @return \string[][]|void
     */
    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name
     * @return bool|void
     */
    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * @param string $name
     * @return string[]|void
     */
    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * @param $name
     */
    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * @param string $name
     * @param string|string[] $value
     * @return Model|void
     */
    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * @param string $name
     * @param string|string[] $value
     * @return Model|void
     */
    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    /**
     * Return an instance without the specified header.
     *
     * @param $name
     */
    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    /**
     * Return an instance with the specified message body.
     *
     * @param StreamInterface $body
     * @return Model|void
     */
    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    /**
     * Retrieves the message's request target.
     *
     * @return string|void
     */
    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    /**
     * Return an instance with the specific request-target.
     *
     * @param mixed $requestTarget
     * @return Model|void
     */
    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * @param $method
     */
    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    /**
     * Retrieves the URI instance.
     *
     * @return UriInterface|void
     */
    public function getUri()
    {
        // TODO: Implement getUri() method.
    }

    /**
     * Returns an instance with the provided URI.
     *
     * @param UriInterface $uri
     * @param false $preserveHost
     * @return Model|void
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }

    /**
     * Retrieve server parameters.
     *
     * @return array
     */
    public function getServerParams(): array
    {
        $this->serverParams = $_SERVER;
        return $this->serverParams;
    }

    /**
     * Retrieve cookies.
     *
     * @return array
     */
    public function getCookieParams(): array
    {
        $this->cookieParams = $_COOKIE;
        return $this->cookieParams;
    }

    /**
     * Return an instance with the specified cookies.
     *
     * @param array $cookies
     * @return Model|void
     */
    public function withCookieParams(array $cookies)
    {
        $this->cookieParams = $cookies;

        $cookie_name = array_keys($cookies);
        $cookie_name = $cookie_name[0];
        $cookie_value = array_values($cookies);
        $cookie_value = $cookie_value[0][0];

        if (is_array($cookie_value))
            setcookie($cookie_name, serialize($cookie_value), time()+259200, "/"); // 3 days
        else
            setcookie($cookie_name, $cookie_value, time()+259200, '/');
    }

    /**
     * Retrieve query string arguments.
     *
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * @param array $query
     * @return array
     */
    public function withQueryParams(array $query): array
    {
        return $this->queryParams = $query;
    }

    /**
     * Retrieve normalized file upload data.
     *
     * @return array|void
     */
    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * @param array $uploadedFiles
     * @return Model|void
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * @return array|object|void|null
     */
    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * @param array|object|null $data
     * @return Model|void
     */
    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * @return array|void
     */
    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * @param string $name
     * @param null $default
     * @return mixed|void
     */
    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * @param string $name
     * @param mixed $value
     * @return Model|void
     */
    public function withAttribute($name, $value)
    {
        // TODO: Implement withAttribute() method.
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * @param string $name
     * @return Model|void
     */
    public function withoutAttribute($name)
    {
        // TODO: Implement withoutAttribute() method.
    }
}
