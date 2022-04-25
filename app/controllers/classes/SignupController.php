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
    private $errors = [];

    public function __construct($login="",$pwd="", $pwdRepeat="", $email="")
    {
        $this->login = $login;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;

        parent::__construct();
    }

    public function signup(): array
    {
        if (!$this->checkUser()){
            $hash = md5($this->login.time());

            $this->pwd = password_hash($this->pwd, PASSWORD_DEFAULT);
            $values = [$this->login,$this->email,$this->pwd,$hash,0];
            $this->create('user', 'login, email, password, hash, email_confirmed', $values);

            $to = $this->email;
            $subject = "=?UTF-8?B?".base64_encode("Confirm e-mail")."?=";
            $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
            $message = "<a href='".SITEPATH."/confirm?hash=".$hash."'>Follow this link to confirm your account</a>";

            if (!mail($to, $subject, $message, $additional_headers))
                $this->errors['emailNotSent'] = true;
        }

        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    private function checkUser()
    {
        if ($this->emptyData($this->login, "noLogin")) return true;
        if ($this->emptyData($this->pwd, "noPassword")) return true;
        if ($this->emptyData($this->email, "noEmail")) return true;
        if ($this->emptyData($this->pwdRepeat, "noPasswordRepeat")) return true;
        if ($this->wrongEmail()) return true;
        if ($this->passwordsNotEqual()) return true;
        if ($this->userExists()) return true;
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