<?php

// define commands should be in a config.php file actually XD
require '../config/config.php';
require '../core/Helper.php';
require '../core/Database/DatabaseHandler.php';
require '../core/Database/Entity.php';
require '../core/Controller.php';
require '../core/Pagination.php';

if(isset($_GET['request'])) {
    session_start();
    $url = explode("/", $_GET['request']);
    $controller = $url[0];
    $action = $url[1];
   //  $param = $url[2];
    $controllerName =  $controller . 'Controller';
    $controllerName2 = 'Controllers' . $controller . 'Controller';
    // echo $controllerName2;
    require '../app/Controllers/' . $controllerName . '.php';
    $str = "\Controllers\_" . $controllerName;
    $controllerObj = new $controllerName;
    $controllerObj->{$action}();
    // echo $controllerName;
} else {
    Helper::Redirect('Home', 'Index');
}