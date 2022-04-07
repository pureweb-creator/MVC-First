<?php

use models\Model;

$model = new Model();
$cookies = $model->getCookieParams();

if (isset($cookies['logged_user']))
    setcookie("logged_user", "", time() - 3600, "/");
header("Location: ./home");