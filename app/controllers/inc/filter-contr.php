<?php
require_once realpath('../../kernel/config.php');
use controllers\classes\Controller;

$data = $_GET;

$categories = @$data['categories'];
$ordering = @$data['ordering'];

$contr = new Controller();
$products = $contr->filter(
    [
        'order_by' => explode("|", $ordering),
        'conditions' => [
            'category_id' => $categories = empty($categories[0]) ? false : explode(",", $categories)
        ] ?? false
    ]
);

echo $contr->makeResponse($products);