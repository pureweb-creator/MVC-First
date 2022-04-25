<?php
require_once realpath('../../kernel/config.php');
use controllers\classes\LoginController;

$data = $_POST;
list($login,$password) = array_values($data);
$contr = new LoginController($login,$password);
$contr->login();