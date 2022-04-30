<?php

namespace controllers\traits;

trait CheckInfo
{
    private function wrongLoginData(): array
    {
        if (!$this->user || !password_verify($this->password, $this->user[0]['password'])){
            $this->response['wrongData'] = true;
            $this->response['errorsMessage'] = $this->errorMsg["wrongData"];
        }
        return $this->response;
    }

    private function allowedLogin(): array
    {
        if (!preg_match('/^(?=.{5,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $this->login)){
            $this->response['notValidLogin'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['notValidLogin'];

        }
        return $this->response;
    }

    private function emptyData($data, $errorMessage): array
    {
        if (empty($data)){
            $this->response[$errorMessage] = true;
            $this->response['errorsMessage'] = $this->errorMsg[$errorMessage];
        }
        return $this->response;
    }

    private function wrongEmail(): array
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->response['wrongEmail'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['wrongEmail'];

        }
        return $this->response;
    }

    private function passwordsNotEqual(): array
    {
        if ($this->pwdRepeat !== $this->pwd){
            $this->response['notEqualPassword'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['notEqualPassword'];
        }

        return $this->response;
    }

    private function userExists(): array
    {
        if ($this->load("user", "login = ? OR email = ?", [$this->login, $this->email])){
            $this->response['userExists'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['userExists'];

        }
        return $this->response;
    }

    private function wrongPassword(): array
    {
        if (strlen($this->pwd) > 60){
            $this->response["wrongPassword"] = true;
            $this->response['errorsMessage'] = $this->errorMsg['wrongPassword'];

        }
        return $this->response;
    }

    private function noUserExists(): array
    {
        if (!$this->load('user', 'email = ?', [$this->email])){
            $this->response['noUserExists'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['noUserExists'];

        }
        return $this->response;
    }

    private function hashExists($hash)
    {
        if (!$this->load("user", "hash = ?", [$hash]))
            return false;
    }

    private function isInCart(): array
    {
        if ($this->load('cart', 'pid = ? AND uid = ?', [$this->product_id, $this->user_id])){
            $this->response['productAlreadyAdded'] = true;
            $this->response['errorsMessage'] = $this->errorMsg['productAlreadyAdded'];
            $this->response['current_pid'] = $this->product_id;
        }
        return $this->response;
    }
}