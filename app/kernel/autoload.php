<?php
require_once dirname(__DIR__)."../../vendor/autoload.php";
spl_autoload_register(function ($class){
//    echo dirname(__DIR__) . "/$class.php<br>";
    require_once(dirname(__DIR__) . "/$class.php");
});
