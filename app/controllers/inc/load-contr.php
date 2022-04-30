<?php
require_once realpath("../../kernel/config.php");

use controllers\classes\Controller;

$table = $_GET['table'];
$contr = new Controller();
$products = $contr->loadAll($table);

if (!$products)
	$products["empty"] = ERROR_MSG["noProducts"];

echo $contr->makeResponse($products);