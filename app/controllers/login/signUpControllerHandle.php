<?php

use models\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once realpath('../../kernel/autoload.php');

$model = new Model();
$model->withQueryParams($_POST);
$data = $model->getQueryParams();
$errors = [];

list($login,$password,$passwordRepeat,$email) = array_values($data);

if (empty($login)){
    $errors["noLogin"] = true; }

else if (empty($password)) {
    $errors['noPassword'] = true; }

else if (empty($email)) {
    $errors['noEmail'] = true; }

else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $errors['wrongEmail'] = true; }

else if (empty($passwordRepeat)) {
    $errors['noPasswordRepeat'] = true; }

else if ($passwordRepeat !== $password) {
    $errors['notEqualPassword'] = true; }

else if ($model->load('user','email = ?',[$email])) {
    $errors['userExists'] = true; }

else if ($model->load('user','login = ?',[$email])) {
    $errors['userExists'] = true; }

else if (empty($errors)){
    $hash = md5($login.time());
    $password = password_hash($password, PASSWORD_DEFAULT);
    $values = [$login,$email,$password,$hash,0];
    $model->create('user', 'login, email, password, hash, email_confirmed', $values);

    $to = $email;
    $subject = "=?UTF-8?B?".base64_encode("Confirm e-mail")."?=";
    $additional_headers = "Content-type: text/html\nReply-to: testing@gmail.com\nFrom: testing@gmail.com";
    $message = "<a href='http://localhost/phptutor/mvcproj/confirm?hash=".$hash."'>Follow this link to confirm your account</a>";
    
    if (!mail($to, $subject, $message, $additional_headers))
        $errors['emailNotSent'] = true;
}

echo $model->makeResponse($errors);