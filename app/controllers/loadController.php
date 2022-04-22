<?php
require_once realpath('../kernel/autoload.php');

use models\Model;

$model = new Model();
$model->withQueryParams($_GET);
$table = $model->getQueryParams();
$table = $table['table'];
$products = $model->loadAll($table);

echo $model->makeResponse($products);