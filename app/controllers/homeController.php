<?php
use views\View;
use models\Model;

require 'mainController.php';

$model = new Model();
$user = is_logged();

if (isset($user["is_logged_out"])){
    header("Location: ./login");
    exit();
}

$categories = $model->loadAll('category');

$args = [
    "page_title"=>"HOME",
    "logged_user"=>$user,
    "categories"=>$categories,
    "categories_title"=>"Categories"
];

$tpl = new View(false,true);
$tpl->render("home.twig", $args);