<?php


class Startup
{
    private $controller = 'Home';
    private $action = 'Index';
    private $params = [];
    private $id;

    public function __construct() {
        $request = explode("/", $_GET['request']);
        $this->controller = $request[0];
        $this->action = array_key_exists(1, $request)?$request[1]:'Index';
        if(empty($this->action)) {
            $this->action = 'Index';
        }
        $this->id = array_key_exists(2, $request)?$request[2]:null;


        require '../app/Controllers/' . $this->controller . 'Controller.php';
        $controllerClass = $this->controller . 'Controller';
        $controller = new $controllerClass();
        if($this->id == null) {
        $controller->{$this->action}();
        } else {
            $controller->{$this->action}($this->id);
        }
    }
}