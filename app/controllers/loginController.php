<?php
use views\View;

include_once "mainController.php";

$cookies = is_logged();

if (!isset($cookies['is_logged_out']))
    header('Location: ./home');

$args = [
    'page_title' => 'Login',
    'logged_user' => $cookies
];

$tpl = new View(false, true);
$tpl->render('login.twig', $args);