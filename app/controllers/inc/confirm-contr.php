<?php
use controllers\classes\SignupController;

$hash = $_GET['hash'];
if (!isset($hash)) die("Something went wrong");

$contr = new SignupController();
$contr->confirm($hash);