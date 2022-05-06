<?php
require_once realpath('../../kernel/config.php');

use controllers\classes\CartController;

list($quantity,$pid)=array_values($_GET);

$contr = new CartController($pid);
$contr->quantity($quantity);