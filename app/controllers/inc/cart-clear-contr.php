<?php
require_once realpath('../../kernel/autoload.php');

use controllers\classes\CartController;

$cart = new CartController();
$cart->clearCart();