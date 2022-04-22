<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;

$model = new Model();
$model->withQueryParams($_GET);
$query_params = $model->getQueryParams();
$pid = $query_params['id'];
$cookie_params = $model->getCookieParams();
$user = unserialize($cookie_params['logged_user']);
$uid = $user['id'];

$model->remove("cart",'pid = ? AND uid = ?',[$pid,$uid]);