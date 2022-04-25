<?php
require_once "app/kernel/config.php";

$model = new Models\Model();
$fn = key($_GET);

# Start routing
if (empty($fn) || $fn == "home") {
    include 'app/controllers/home.php';
    exit();
}

switch ($fn){
    case 'login': include 'app/controllers/login.php';
        break;
    case 'logout': include 'app/controllers/logout.php';
        break;
    case 'signup': include 'app/controllers/signup.php';
        break;
    case 'forgotPassword': include 'app/controllers/forgot.php';
        break;
    case 'confirm': include 'app/controllers/inc/confirm-contr.php';
        break;
    case 'reset': include 'app/controllers/reset.php';
        break;
    default: include 'app/controllers/404.php';
}