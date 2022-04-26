<?php
require_once realpath("../../kernel/config.php");

use controllers\classes\Controller;

$table = $_GET['table'];
$contr = new Controller();
$products = $contr->loadAll($table);

echo $contr->makeResponse($products);