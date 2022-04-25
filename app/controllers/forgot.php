<?php
use controllers\classes\Controller;
use views\View;
$contr = new Controller();

$user = $contr->is_logged();
if (!isset($user['is_logged_out']))
    header('Location: ./login');

$args = [
    'page_title' => 'Type your e-mail to reset password',
    'logged_user' => $user,
    'root'=>SITEPATH
];

$tpl = new View(false, true);
$tpl->render('forgot.twig', $args);