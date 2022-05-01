<?php
use views\View;
use controllers\classes\Controller;

$contr = new Controller();
$user = $contr->is_logged();

if (isset($user['is_logged_out']))
    header('Location: ./login');

$args = [
    '404'=>'404',
    'page_title'=>'Oops, this page not be found!',
    'page_subtitle'=>'We\'re really sorry, but the page you requested is missing :(',
    'app_id'=>'account',
    'logged_user'=>$user,
    'root'=> $site_path
];

$tpl = new View(false, true);
$tpl->render("404.twig", $args);