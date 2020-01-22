<?php

// print_r($_GET);

if(isset($_GET['controller']) && isset($_GET['action'])) {
    session_start();
    if(!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'en';
        $lang = $_SESSION['lang'];
    }
    $pdo = new PDO("mysql:host=localhost;dbname=timetracking;charset=UTF8", "root", "");
    require 'app/Controllers/BaseController.php';
    require 'app/Controllers/'  . $_GET['controller'] . 'Controller.php';
    $controller = $_GET['controller'] . 'Controller'; $ctrler = new $controller($pdo);
    // print_r($controller); print_r($ctrler);
    $ctrler->{$_GET['action']}();
}

echo substr($controller, 0, -10);