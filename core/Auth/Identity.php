<?php


class Identity
{
    private static $roles = [];

    public static function setRole($role) {
        $_SESSION[APP_SESSION]['role_id'] = $role;
        return 1;
    }

    public static function setUser($user_id) {
        $_SESSION[APP_SESSION]['user_id'] = $user_id;
        return 1;
    }

    public static function setUsername($username) {
        $_SESSION[APP_SESSION]['username'] = $username;
        return 1;
    }

    public static function setEmail($email) {
        $_SESSION[APP_SESSION]['email'] = $email;
        return 1;
    }

    public static function addRoles($roles) {
        foreach($roles as $role) {
            array_push(self::$roles, $role->role_title);
        }
    }

    public static function getRoles() {
        return self::$roles;
    }

    public static function isAdmin() {
        if($_SESSION[APP_SESSION]['role_id'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function isAuthenticated() {
        if(isset($_SESSION[APP_SESSION])) {
            return 1;
        } else {
            return 0;
        }
    }
}