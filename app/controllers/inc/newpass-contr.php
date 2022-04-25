<?php
/**
 * Сюда приходит обработчик из Vue
 */

require_once realpath('../../kernel/config.php');
use controllers\classes\RestorepwdController;

$data = $_POST;
$errors = [];

list($pwd, $pwdRepeat, $email) = array_values($data);
$contr = new RestorepwdController($email);
$contr->restore($pwd, $pwdRepeat);