<?php


class BaseController
{
    public $pdo; // Database connection

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function View() {
        if(file_exists("app/Views/" . $_GET['controller'] . '/' . $_GET['action']) . '.php') {
            $path = "app/Views/" . $_GET['controller'] . '/' . $_GET['action'] . '.php';
            return $path;
        }
    }
}