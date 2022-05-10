<?php

namespace controllers\classes;

use controllers\traits\CheckInfo;

class SignupController extends Controller
{
    use CheckInfo;

    private string $login;
    private string $pwd;
    private string $pwdRepeat;
    private string $email;

    public function __construct($login="",$pwd="", $pwdRepeat="", $email="")
    {
        $this->login = htmlspecialchars(trim($login));
        $this->pwd = htmlspecialchars(trim($pwd));
        $this->pwdRepeat = htmlspecialchars(trim($pwdRepeat));
        $this->email = htmlspecialchars(trim($email));

        parent::__construct();
    }

    public function signup()
    {
        if (!$this->checkUser()){
            $hash = md5($this->login.time());

            $this->pwd = password_hash($this->pwd, PASSWORD_DEFAULT);
            $values = [$this->login,$this->email,$this->pwd,$hash,0];

            if (!$this->create('user', 'login, email, password, hash, email_confirmed', $values)){
               $this->response['smthWentWrong'] = true;
               $this->response['errorsMessage'] = $this->errorMsg["serverError"];
               echo $this->makeResponse($this->response);
               die();
            }

            $to = $this->email;
            $subject = "=?UTF-8?B?".base64_encode("Confirm e-mail")."?=";
            $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
            $message = "<a href='".$this->site_path."/confirm?hash=".$hash."'>Follow this link to confirm your account</a>";

            if (!@mail($to, $subject, $message, $additional_headers))
                $this->response['emailNotSent'] = true;
        }
        
        echo $this->makeResponse($this->response);
        return $this->response;
    }

    private function checkUser()
    {
        if ($this->emptyData($this->login, "noLogin")) return true;
        if ($this->allowedLogin()) return true;
        if ($this->emptyData($this->email, "noEmail")) return true;
        if ($this->wrongEmail()) return true;
        if ($this->userExists()) return true;
        if ($this->emptyData($this->pwd, "noPassword")) return true;
        if ($this->wrongPassword()) return true;
        if ($this->emptyData($this->pwdRepeat, "noPasswordRepeat")) return true;
        if ($this->passwordsNotEqual()) return true;
    }

    // ???
    public function confirm($hash)
    {
        $user = $this->load("user", "hash = ?",[$hash]);
        if (!$this->hashExists($hash)){
            $this->update('user', 'email_confirmed = ?', 'id = ?', [1, $user[0]['id']]);

            $this->withCookieParams([
                'logged_user' => ''
            ]);

            header('Location: ./home');
        }
    }
}