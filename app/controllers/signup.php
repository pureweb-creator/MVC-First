<?php
use controllers\classes\Controller;
use views\View;

$contr = new Controller();
$user = $contr->is_logged();
if (!isset($user['is_logged_out']))
    header('Location: ./home');

$args = [
    'page_title' => 'Sign Up',
    'logged_user' => $user,
    'root'=>SITE_PATH,
    'user_registered'=>"Please, check your email"
];

$tpl = new View(false, true);
$tpl->render('signup.twig', $args);