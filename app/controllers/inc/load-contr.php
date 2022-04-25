<?php
require_once realpath("../../kernel/autoload.php");

use controllers\classes\Controller;

$table = $_GET['table'];
$contr = new Controller();
$products = $contr->readAll($table);

echo $contr->makeResponse($products);