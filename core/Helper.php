<?php


class Helper
{
    public static function validateLength($string, $max, $min) {
        if(strlen($string) > $max || strlen($string) < $min) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function stringMatch($str1, $str2) {
        if($str1 != $str2) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function validateEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function URL($controller, $action, $id = null, $idValue = null) : ?string {
        if($id != null) {
            // $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&id=" . $id;
            $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "/" . $id;
            return $url;
        }
        $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action;
        return $url;
    }

    public static function Redirect($controller, $action, $id = null) {
        $url = self::URL($controller, $action, $id);
        header("Location: " . $url);
    }
}