<?php
use controllers\classes\Controller;
use views\View;

$contr = new Controller();

$user = $contr->is_logged();
if (isset($user['is_logged_out']))
    header('Location: ./login');

$categories = $contr->readAll('category');

$args = [
    "page_title"=>"HOME",
    "categories_title"=>"Options",
    "app_id"=>"account",
    "logged_user"=>$user,
    "categories"=>$categories,
    "root"=>SITEPATH
];
$tpl = new View(false,true);
$tpl->render("home.twig", $args);