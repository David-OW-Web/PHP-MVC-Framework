<?php


class Controller
{
    public $entity;
    private $request;
    private $controller;
    private $action;
    public function __construct() {
       $this->request = $_GET['request'];
        $explodeRequest = explode("/", $_GET['request']);
        $this->controller = $explodeRequest[0];
        $this->action = $explodeRequest[1];
        // $param = $explodeRequest[2];
        $this->entity = new Entity();
    }

    public function View($data = [], $layout = null, $view = null) {
        if(!$view) {
            if($layout == null) {
                $path = "../app/Views/" . $this->controller . "/" . $this->action . ".php";
                require $path;
            } else {
                require "../app/Views/Layout/header.php";
                $path = "../app/Views/" . $this->controller . "/" . $this->action . ".php";
                require $path;
                require "../app/Views/Layout/footer.php";
            }
        } else {
            require $view;
        }

        /*
        if($layout && !$view) {
            require '../app/Views/Layout/navbar.php';
            $path = "../app/Views/" . $this->controller . "/" . $this->action . ".php";
            require $path;
        }
        */
    }

    public function render(array $data, $view) {
        $content = file_get_contents($view);
        foreach($data as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }
        return $content;
    }

    public function loadModel($model) {
        require 'app/Models/' . $model . '.php';
        return new $model();
    }
}