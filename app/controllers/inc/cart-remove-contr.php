<?php
require_once realpath('../../kernel/autoload.php');

use controllers\classes\CartController;
$pid = $_GET['id'];
$cart = new CartController($pid);
$cart->removeFromCart();