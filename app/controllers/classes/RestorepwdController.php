<?php

namespace controllers\classes;
use controllers\traits\CheckInfo;

class RestorepwdController extends Controller
{
    use CheckInfo;

    private string $email;
    private string $pwd;
    private string $pwdRepeat;

    public function __construct($email)
    {
        if (is_null($email))
            header("Location: ./home");

        $this->email = htmlspecialchars($email);
        parent::__construct();
    }

    public function forgot(): array
    {
        if (!$this->checkUser()){

            $hash = md5($this->email . time());

            if (!$this->update('user', 'hash = ?', 'email = ?', [$hash, $this->email])){
                $this->response['smthWentWrong'] = true;
                echo $this->makeResponse($this->response);
                die();
            }

            $to = $this->email;
            $subject = '=?UTF-8?B?' . base64_encode('Reset password') . '?=';
            $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
            $message = "<a href='" . $this->site_path . '/reset?hash=' . $hash . "'>Follow this link to confirm your account</a>";

            if (!@mail($to, $subject, $message, $additional_headers))
                $this->response['notSent'] = true;

            $this->response['success'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['success'];
        }

        echo $this->makeResponse($this->response);
        return $this->response;
    }

    public function restore($pwd, $pwdRepeat): array
    {
        $this->pwd = htmlspecialchars($pwd);
        $this->pwdRepeat = htmlspecialchars($pwdRepeat);

        if (!$this->checkUserNewPwd()){
            $this->pwd = password_hash($this->pwd, PASSWORD_DEFAULT);

            if (!$this->update('user', 'password = ?', 'email = ?', [$this->pwd, $this->email])){
                $this->response['smthWentWrong'] = true;
                echo $this->makeResponse($this->response);
                die();
            }
        }

        echo $this->makeResponse($this->response);
        return $this->response;
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
