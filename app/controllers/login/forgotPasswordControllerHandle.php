<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;

$model = new Model();
$model->withQueryParams($_POST);
$params = $model->getQueryParams();
$errors = [];

$email = $params['email'];

if (empty($email)){
    $errors["noUserExists"] = true; }

else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['wrongEmail'] = true; }

else if (!($user = $model->load('users', 'email = ?', [$email]))){
    $errors["noUserExists"] = true; }

else {
    $to = $email;
    $hash = md5($email.time());
    $subject = '=?UTF-8?B?' . base64_encode('Reset password') . '?=';
    $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
    $message = "<a href='http://localhost/phptutor/mvcproj/reset?hash=" . $hash . "'>Follow this link to confirm your account</a>";

    $model->update('user', 'hash = ?', 'email = ?', [$hash, $email]);
    if (!@mail($to, $subject, $message, $additional_headers)){
        $errors["notSent"] = true;
    }

    $errors["success"] = true;
}

print_r($model->makeResponse($errors));