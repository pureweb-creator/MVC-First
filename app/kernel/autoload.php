<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/phptutor/mvcproj/vendor/autoload.php';

spl_autoload_register(function ($class){
    require_once(dirname(__DIR__) . "/$class.php");
});
