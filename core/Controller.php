<?php


class Controller
{
    public $entity;
    private $request;
    private $controller;
    private $action;
    public $id;
    public $user_id;
    public $identity;
    public $authenticated;
    public function __construct() {
       $this->request = $_GET['request'];
        $explodeRequest = explode("/", $_GET['request']);
        $this->controller = $explodeRequest[0];
        $this->action = array_key_exists(1, $explodeRequest)?$explodeRequest[1]:'Index';
        $this->id = array_key_exists(2, explode("/", $this->request))?explode("/", $this->request)[2]:'No id given';
        $this->user_id = isset($_SESSION[APP_SESSION]['user_id'])?$_SESSION[APP_SESSION]['user_id']:'';
        $this->identity = isset($_SESSION[APP_SESSION])?$_SESSION[APP_SESSION]:'';
        $this->authenticated = isset($_SESSION[APP_SESSION])?1:0;
        /*
        if(empty($this->id)) {
            Helper::Redirect("Home", "Index");
        }
        */
        // $param = $explodeRequest[2];
        $this->entity = new Entity();
    }

    public function View($data = [], $layout = null, $view = null) {
        if(!$view) {
            if($layout == null) {
                if(empty($this->action)) {
                    $this->action = "Index";
                }
                $path = "../app/Views/" . $this->controller . "/" . $this->action . ".php";
                require $path;
            } else {
                require "../app/Views/Layout/header.php";
                // actually bad logic if(isset($_SESSION['news_app_user']) && $_SESSION['news_app_user']['role_id'] == 1 && $this->controller == "DashBoard")
                if(empty($this->action)) {
                    $this->action = "Index";
                }
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