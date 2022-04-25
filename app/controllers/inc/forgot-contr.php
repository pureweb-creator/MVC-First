<?php
use controllers\classes\RestorepwdController;

$email = @$_POST['email'];
$contr = new RestorepwdController($email);
$contr->forgot();