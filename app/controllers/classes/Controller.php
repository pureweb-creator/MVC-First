<?php
namespace controllers\classes;

use models\Model;
use models\Filter;

class Controller extends Model
{
    protected $response = [];
    protected $errorMsg = ERROR_MSG;
    protected $site_path = SITE_PATH;

    public function __construct()
    {
        parent::__construct();
    }

    public function is_logged(){
        $cookies = $this->getCookieParams();
        return isset($cookies['logged_user']) ? unserialize($cookies['logged_user']) : ['is_logged_out' => 'true'];
    }

    public function logout()
    {
        $cookies = $this->getCookieParams();

        if (isset($cookies['logged_user']))
            setcookie('logged_user', '', time() - 3600, '/');
        header('Location: ./home');
    }

    public function filter($array)
    {
        $filter = new Filter();
        return $filter->filterProducts($array);
    }

}