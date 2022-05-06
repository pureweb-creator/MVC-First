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

        // отдельный массив где из таблицы корзины выбрано только поле "count"
        $quantity = array_values($cart->getQuantity($this->user_id));
        // массив айдишников из таблицы корзины
        $products_in_cart_ids = $cart->loadCart([$this->user_id]);

        if (!empty($products_in_cart_ids) && $products_in_cart_ids) {

            // по айдишникам выбираем продукты из БД
            $this->products = $this->loadProducts([
                'product_id' => $products_in_cart_ids
            ]);

            // в результирующий массив приклеиваем count какие выбрали ранее
            for ($i=0;$i<count($quantity);$i++)
                $this->products[$i] += ['quantity'=>$quantity[$i]["count"]];

            // пересчитываем цену
            foreach ($this->products as $item)
                $this->totals += $item['price']*$item["quantity"];

            echo $this->makeResponse($this->response = [$this->products, count($this->products), $this->totals, $quantity]);
            return true;
        }

        $this->response = ["empty"=>$this->errorMsg["noProducts"]];
        echo $this->makeResponse($this->response);
        return true;
    }

    public function quantity($quantity)
    {
        $this->update('cart', 'count = ?', 'uid = ? AND pid = ?', [$quantity, $this->user_id, $this->product_id]);

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