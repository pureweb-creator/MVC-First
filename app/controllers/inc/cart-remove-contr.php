<?php
require_once realpath('../../kernel/config.php');

use controllers\classes\CartController;
$pid = $_GET['id'];
$cart = new CartController($pid);
$cart->removeFromCart();