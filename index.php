<?php

/**
 * 1. Убираем autoload, оствляем только тот что для vendor
 * 2. Все файлы в контроллерах подключаем вручную
 * 2.1 Пути в подключаемых файлах должны быть абсолютными
 * - При необходимости перехватить выходной поток (буферизация вывода)
 * 3. Все что в файлах *Handle.php переходит в методы классов контроллера.
 * 3.1 Создать котроллеры под фильтр, корзину и авторизацию
 * 3.2 Создать папку controllers/classes
 * 3.3 Придумать какой-то другой нейминг контроллеров. Например, load.contr.php и filter.classes.php или че-то наподобие
 */

require realpath('app/kernel/autoload.php');

$model = new Models\Model();
$model->withQueryParams($_GET);
$fn = key($model->getQueryParams());

# Start routing
if (empty($fn) || $fn == "home") {
    include 'app/controllers/homeController.php';
    exit();
}

if (!file_exists("app/controllers/".$fn."Controller.php"))
    include 'app/controllers/notFoundController.php';

switch ($fn){
    case 'login': include 'app/controllers/loginController.php';
        break;
    case 'logout': include 'app/controllers/logoutController.php';
        break;
    case 'signup': include 'app/controllers/signUpController.php';
        break;
    case 'forgotPassword': include 'app/controllers/forgotPasswordController.php';
        break;
    case 'confirm': include 'app/controllers/confirmController.php';
        break;
    case 'reset': include 'app/controllers/resetController.php';
        break;
}