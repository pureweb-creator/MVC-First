<?php

namespace controllers\classes;
use controllers\traits\CheckInfo;

class RestorepwdController extends Controller
{
    use CheckInfo;

    private string $email;
    private string $pwd;
    private string $pwdRepeat;
    private $errors = [];

    public function __construct($email)
    {
        if (is_null($email))
            header("Location: ./home");

        $this->email = $email;
        parent::__construct();
    }

    public function forgot(): array
    {
        if (!$this->checkUser()){
            $to = $this->email;
            $hash = md5($this->email . time());
            $subject = '=?UTF-8?B?' . base64_encode('Reset password') . '?=';
            $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
            $message = "<a href='".SITEPATH."/reset?hash=" . $hash . "'>Follow this link to confirm your account</a>";

            $this->update('user', 'hash = ?', 'email = ?', [$hash, $this->email]);
            if (!@mail($to, $subject, $message, $additional_headers))
                $this->errors['notSent'] = true;
            $this->errors['success'] = true;
        }

        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    public function restore($pwd, $pwdRepeat): array
    {
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;

        if (!$this->checkUserNewPwd()){
            $this->pwd = password_hash($this->pwd, PASSWORD_DEFAULT);
            $this->update('user', 'password = ?', 'email = ?', [$this->pwd, $this->email]);
        }

        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    private function checkUser()
    {
        if ($this->emptyData($this->email, "noUserExists")) return true;
        if ($this->wrongEmail()) return true;
        if ($this->noUserExists()) return true;
    }

    private function checkUserNewPwd()
    {
        if ($this->emptyData($this->pwd, 'noPassword')) return true;
        if ($this->emptyData($this->email, 'noEmail')) return true;
        if ($this->wrongEmail()) return true;
        if ($this->emptyData($this->pwdRepeat, 'noPasswordRepeat')) return true;
        if ($this->passwordsNotEqual()) return true;
    }
}
