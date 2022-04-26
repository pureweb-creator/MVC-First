<?php

namespace controllers\classes;
use controllers\traits\CheckInfo;

class LoginController extends Controller
{
    use CheckInfo;

    private string $login;
    private string $password;
    private array $user = [];
    private $errors = [];

    public function __construct($login, $password)
    {
        $this->login = htmlspecialchars($login);
        $this->password = htmlspecialchars($password);

        parent::__construct();
    }

    public function login(): array
    {
        $this->user = $this->load('user', 'login = ?', [$this->login]);

        if (!$this->checkUser()){
            $this->withCookieParams([
                'logged_user'=>$this->user
            ]);
        }

        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    private function checkUser()
    {
        if ($this->wrongLoginData()) return true;
    }

}