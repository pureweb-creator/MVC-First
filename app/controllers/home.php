<?php
use controllers\classes\Controller;
use views\View;

$contr = new Controller();

$user = $contr->is_logged();
if (isset($user['is_logged_out']))
    header('Location: ./login');

$categories = $contr->loadAll('category');

if (!$categories)
    $errorText = ERROR_MSG["serverError"];
global $errorText;

$args = [
    "page_title"=>"HOME",
    "categories_title"=>"Options",
    "app_id"=>"account",
    "logged_user"=>$user,
    "categories"=>$categories,
    "errorText"=>$errorText,
    "root"=>$site_path
];

$tpl = new View(false,true);
$tpl->render("home.twig", $args);