<?php
require_once realpath('../../kernel/config.php');

use controllers\classes\CartController;

$pid = $_GET['pid'];
$cart = new CartController($pid);
$cart->addToCart();