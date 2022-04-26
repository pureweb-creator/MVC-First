<?php

namespace controllers\traits;

trait CheckInfo
{
    private function wrongLoginData(): array
    {
        if (!$this->user || !password_verify($this->password, $this->user[0]['password']))
            $this->errors['wrongData'] = true;
        return $this->errors;
    }

    private function allowedLogin(): array
    {
        if (preg_match('/[\'^$%!@^&*;()}{@#~?><>,|=+-]/', $this->login) || strlen($this->login) > 20)
            $this->errors['notValidLogin'] = true;
        return $this->errors;
    }

    private function emptyData($data, $errorMessage): array
    {
        if (empty($data))
            $this->errors[$errorMessage] = true;
        return $this->errors;
    }

    private function wrongEmail(): array
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->errors['wrongEmail'] = true;
        return $this->errors;
    }

    private function passwordsNotEqual(): array
    {
        if ($this->pwdRepeat !== $this->pwd)
            $this->errors['notEqualPassword'] = true;
        return $this->errors;
    }

    private function userExists(): array
    {
        if ($this->load("user", "login = ? OR email = ?", [$this->login, $this->email]))
            $this->errors['userExists'] = true;
        return $this->errors;
    }

    private function noUserExists(): array
    {
        if (!$this->load('user', 'email = ?', [$this->email]))
            $this->errors['noUserExists'] = true;
        return $this->errors;
    }

    private function hashExists($hash)
    {
        if (!$this->load("user", "hash = ?", [$hash]))
            return false;
    }

    private function isInCart(): array
    {
        if ($this->load('cart', 'pid = ? AND uid = ?', [$this->product_id, $this->user_id]))
            $this->errors['productAlreadyAdded'] = true;
        return $this->errors;
    }



}