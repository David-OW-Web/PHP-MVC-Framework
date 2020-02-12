<?php


class Session
{
    public static function setSession($key, $value) {
        return $_SESSION[$key] = $value;
    }

    public static function getSession($key) {
        return $_SESSION[$key];
    }

    public static function checkSession($key) {
        if(isset($_SESSION[$key])) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function endSession($key) {
        unset($_SESSION[$key]);
        return 1;
    }
}