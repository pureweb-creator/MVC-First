<?php


require realpath('app/kernel/autoload.php');

$model = new Models\Model();
$model->withQueryParams($_GET);
$fn = key($model->getQueryParams());

# routing
if (empty($fn) || $fn == "home") {
    include 'app/controllers/homeController.php';
    exit();
}

if (!file_exists("app/controllers/".$fn."Controller.php"))
    include 'app/controllers/notFoundController.php';

switch ($fn){
    case 'login': include 'app/controllers/loginController.php';
        break;
    case 'logout': include 'app/controllers/logoutController.php';
        break;
    case 'signup': include 'app/controllers/signUpController.php';
        break;
    case 'forgotPassword': include 'app/controllers/forgotPasswordController.php';
        break;
    case 'confirm': include 'app/controllers/confirmController.php';
        break;
    case 'reset': include 'app/controllers/resetController.php';
        break;
}