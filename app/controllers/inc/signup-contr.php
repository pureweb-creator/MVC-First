<?php
require_once realpath('../../kernel/autoload.php');
use controllers\classes\SignupController;

$data = $_POST;
list($login,$pwd,$pwdRepeat,$email) = array_values($data);

$contr = new SignupController($login, $pwd, $pwdRepeat, $email);
$contr->signup();