<?php
/**
 * Сюда мы попадаем из письма
 */
use models\Model;
use views\View;
require 'mainController.php';

$model = new Model();
$model->withQueryParams($_GET);
$params = $model->getQueryParams();
$hash = $params['hash'];

$is_logged = is_logged();

if (!isset($hash)) die('Something went wrong');

$user = $model->load('user', 'hash = ?', [$hash]);
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