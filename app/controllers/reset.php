<?php
/**
 * Сюда мы попадаем из письма
 */
use controllers\classes\Controller;
use views\View;

$hash = $_GET['hash'];
$contr = new Controller();
$is_logged = $contr->is_logged();

if (!isset($hash)) die('Something went wrong');

$user = $contr->load('user', 'hash = ?', [$hash]);
$user = $user[0];

if ($user) {

    $args = [
        'page_title' => 'Enter new password',
        'logged_user' => $is_logged,
        'user' => $user
    ];

    $tpl = new View(false, true);
    $tpl->render('reset.twig', $args);
}