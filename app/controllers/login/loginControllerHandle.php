<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;

$model = new Model();
$model->withQueryParams($_POST);
$data = $model->getQueryParams();
$errors = [];

list($login,$password) = array_values($data);
$user = $model->load('user', 'login = ?', [$login]);

if ( $user && password_verify($password, $user[0]["password"])){
    $cookies = $model->withCookieParams([
        'logged_user'=>$user
    ]);
}
else {
    $errors["wrongData"] = true;

}

echo $model->makeResponse($errors);

