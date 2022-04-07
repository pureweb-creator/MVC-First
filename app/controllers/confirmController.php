<?php
use models\Model;

$model = new Model();
$model->withQueryParams($_GET);
$params = $model->getQueryParams();
$hash = $params['hash'];

if (!isset($hash)) die("Something went wrong");

$user = $model->load('user', 'hash = ?', [$hash]);
if ($user){
    $model->update("user", "email_confirmed = ?", "id = ?", [1,$user[0]["id"]]);
    header("Location: ./home");
}