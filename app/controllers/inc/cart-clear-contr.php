<?php
require_once realpath('../../kernel/config.php');

use controllers\classes\CartController;

$cart = new CartController();
$cart->clearCart();