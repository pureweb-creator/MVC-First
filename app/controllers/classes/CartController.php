<?php

namespace controllers\classes;

use controllers\traits\CheckInfo;
use models\Cart;

class CartController extends Controller
{
    use CheckInfo;

    private int $user_id;
    private int $product_id;
    private int $totals = 0;
    private $products = [];
    private $errors = [];

    public function __construct($pid = 0)
    {
        $user = $this->is_logged();
        $this->user_id = $user['id'];
        $this->product_id = $pid;
        parent::__construct();
    }

    public function loadCart(): array
    {
        $cart = new Cart();
        $products_in_cart_ids = $cart->loadCart([$this->user_id]);

        if (!empty($products_in_cart_ids)) {
            $this->products = $this->loadProducts([
                'product_id' => $products_in_cart_ids
            ]);

            foreach ($this->products as $item)
                $this->totals += $item['price'];
        }

        $this->errors = [$this->products, count($this->products), $this->totals];
        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    public function addToCart(): array
    {
        if (!$this->checkData())
        {
            $this->create('cart', 'pid,uid', [$this->product_id, $this->user_id]);
            $this->errors['ok'] = true;
        }

        echo $this->makeResponse($this->errors);
        return $this->errors;
    }

    public function clearCart()
    {
        $this->remove('cart', 'uid = ?', [$this->user_id]);
    }

    public function removeFromCart()
    {
        $this->remove('cart', 'pid = ? AND uid = ?', [$this->product_id, $this->user_id]);
    }

    private function checkData()
    {
        if ($this->isInCart()) return true;

    }


}