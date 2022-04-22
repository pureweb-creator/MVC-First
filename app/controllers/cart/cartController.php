<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;

$model = new Model();
$model->withQueryParams($_GET);
$query_params = $model->getQueryParams();
$pid = $query_params['pid'];
$response = [];

$cookie_params = $model->getCookieParams();
$user = unserialize($cookie_params['logged_user']);
$uid = $user['id'];

if ($model->load("cart", "pid = ? AND uid = ?", [$pid,$uid]))
    $response["productAlreadyAdded"] = true;
else
    $model->create('cart', 'pid,uid', [$pid, $uid]);

$response["ok"] = true;
echo $model->makeResponse($response);