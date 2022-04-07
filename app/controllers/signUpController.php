<?php
use views\View;
use models\Model;

require 'mainController.php';
$cookies = is_logged();

if (!isset($cookies['is_logged_out'])) {
    header('Location: ./home');
}

$args = [
    'page_title' => 'Sign Up',
    'logged_user' => $cookies,
    'user_registered'=>"Please, check your email"
];

$tpl = new View(false, true);
$tpl->render('signup.twig', $args);