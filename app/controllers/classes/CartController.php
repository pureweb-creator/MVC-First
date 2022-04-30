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
    private $products;

    public function __construct($pid = 0)
    {
        $user = $this->is_logged();
        $this->user_id = (int) $user['id'];
        $this->product_id = (int) $pid;
        parent::__construct();
    }

    public function loadCart()
    {
        $cart = new Cart();
        $products_in_cart_ids = $cart->loadCart([$this->user_id]);

        if (!empty($products_in_cart_ids) && $products_in_cart_ids) {
            $this->products = $this->loadProducts([
                'product_id' => $products_in_cart_ids
            ]);

            foreach ($this->products as $item)
                $this->totals += $item['price'];

            echo $this->makeResponse($this->response = [$this->products, count($this->products), $this->totals]);
            return true;
        }

        $this->response = ["empty"=>$this->errorMsg["noProducts"]];
        echo $this->makeResponse($this->response);
        return true;
    }

    public function addToCart(): array
    {
        if (!$this->checkData())
        {
            $this->create('cart', 'pid,uid', [$this->product_id, $this->user_id]);
            $this->response['ok'] = true;
        }

        echo $this->makeResponse($this->response);
        return $this->response;
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