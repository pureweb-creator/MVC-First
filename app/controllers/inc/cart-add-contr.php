<?php
require_once realpath('../../kernel/autoload.php');

use controllers\classes\CartController;

$pid = $_GET['pid'];
$cart = new CartController($pid);
$cart->addToCart();