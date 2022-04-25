<?php
/**
 * Abstract class for Database connection
 *
 * @author Roman S. <roman.semenikhin99@gmail.com>
 * @package Model
 */
namespace models;

/**
 * Dbh. Class for PDO Database connection.
 * @abstract
 */
abstract class Dbh
{
    /**
     * Hostname
     *
     * @var string
     */
	private $host;

    /**
     * Database user password
     * @var string
     */
	private $pass;

    /**
     * Database user name
     * @var string
     */
	private $user;

    /**
     * Database name
     *
     * @var string
     */
    private $db;

    /**
     * Database charset
     *
     * @var string
     */
	private $charset;

    /**
     * PDO options array
     *
     * @var array
     */
	private $opt;

    /**
     * PDO dsn for connection
     *
     * @var string
     */
    private $dsn;

    /**
     * Sets data for connection
     */
	public function __construct(){

		$this->host = "localhost";
		$this->pass = "";
		$this->user = "root";
		$this->charset = "utf8";
        $this->db = "mvcproj_development";
		$this->opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    }

    /**
     * Connection to database using PDO
     *
     * @return \PDO|void
     */
	protected function connect(){
		try{
            return new \PDO($this->dsn, $this->user, $this->pass, $this->opt);
		} catch (\PDOException $e){
			die("No connection to database");
		}
	}
}
