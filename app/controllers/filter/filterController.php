<?php
require_once realpath('../../kernel/autoload.php');
use models\Model;
use models\Filter;

$model = new Model();
$filter = new Filter();

$model->withQueryParams($_GET);
$data = $model->getQueryParams();

$categories = @$data['categories'];
$ordering = @$data['ordering'];

$option_1 = "category_id";

// (^_^) //
$products = $filter->filterProducts(
    [
        'order_by' => explode("|", $ordering),
        'conditions' => [
            $option_1 => $categories = empty($categories[0]) ? false : explode(",", $categories)
        ] ?? false
    ]
);

echo $model->makeResponse($products);