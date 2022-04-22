<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;

$model = new Model();
$cookie_params = $model->getCookieParams();
$user = unserialize($cookie_params['logged_user']);
$uid = $user['id'];

$model->remove('cart', 'uid = ?', [$uid]);