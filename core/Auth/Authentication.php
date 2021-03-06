<?php


class Authentication extends DatabaseHandler
{
    protected $table = "app_user";
    private $con;

    public function __construct() {
        $dbh = new DatabaseHandler();
        $this->con = $dbh->getCon();
    }

    public function Login($information, $password) {
        $stmt = $this->con->prepare("SELECT * FROM $this->table WHERE username = :username AND user_password = :password OR email = :username AND user_password = :password");
        $stmt->bindParam(":username", $information);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        if($stmt->rowCount == 1) {
            $userdata = $stmt->fetch();
            Session::setSession("news_app_user", array(
                "username" => $userdata['username'],
                "email" => $userdata['email'],
                "role_id" => $userdata['fk_role_id']
            ));
        } else {
            return 0;
        }
    }

    public static function CheckSession($key) {
        if(isset($_SESSION[$key])) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function CheckRole($id) {

    }

    public static function isAdmin($key, $role_key) {
        if(isset($_SESSION[$key][$role_key]) && $_SESSION[$key][$role_key] == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}