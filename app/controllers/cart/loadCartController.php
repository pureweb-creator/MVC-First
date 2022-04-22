<?php
require_once realpath('../../kernel/autoload.php');

use models\Model;
use models\Cart;

$model = new Model();
$cart = new Cart();
$cookie_params = $model->getCookieParams();
$user = unserialize($cookie_params['logged_user']);
$uid = $user['id'];

$products_in_cart_ids = $cart->loadCart([$uid]);
if (!empty($products_in_cart_ids)) {
    $products_in_cart = $model->loadProducts([
        "product_id" => $products_in_cart_ids
    ]);

    $totals = 0;
    foreach ($products_in_cart as $item){
        $totals += $item['price'];
    }

    $response = [$products_in_cart, count($products_in_cart), $totals];
    echo $model->makeResponse($response);
}
