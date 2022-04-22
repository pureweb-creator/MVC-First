<?php
use views\View;

//require_once "/models/Model.php";

include 'mainController.php';
$cookies = is_logged();

if (!isset($cookies['is_logged_out']))
    header('Location: ./home');

$args = [
    'page_title' => 'Type your e-mail to reset password',
    'logged_user' => $cookies
];

$tpl = new View(false, true);
$tpl->render('forgot.twig', $args);