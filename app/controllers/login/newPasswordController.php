<?php
/**
 * Сюда приходит обработчик из Vue
 */
use models\Model;

require_once realpath('../../kernel/autoload.php');

$model = new Model();
$model->withQueryParams($_POST);
$data = $model->getQueryParams();
$errors = [];

list($pass, $passRepeat, $email) = array_values($data);

if (empty($pass)){
    $errors['noPassword'] = true; }

if (empty($email)){
    $errors['noEmail'] = true; }

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['wrongEmail'] = true; }

if (empty($passRepeat)){
    $errors['noPasswordRepeat'] = true; }

else if ($pass != $passRepeat){
    $errors['notEqualPasswords'] = true; }

else {
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $model->update("user", "password = ?", "email = ?", [$pass, $email]);
}

echo $model->makeResponse($errors);