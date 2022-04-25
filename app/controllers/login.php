<?php
use controllers\classes\Controller;
use views\View;

$contr = new Controller();
$user = $contr->is_logged();
if (!isset($user['is_logged_out']))
    header('Location: ./home');

$args = [
    'page_title' => 'Login',
    'logged_user' => $user,
    'root'=>SITEPATH
];

$tpl = new View(false, true);
$tpl->render('login.twig', $args);