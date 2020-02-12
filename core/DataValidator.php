<?php


class DataValidator
{
    public static function validateLength($string, $maxLength, $minLength) {
        if(strlen($string) > $maxLength || strlen($string) < $minLength) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function required($field) {
        if(empty($string)) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function compare($string1, $string2) {
        if($string1 != $string2) {
            return 0;
        } else {
            return 0;
        }
    }

    public static function alphaNumeric($string) {
        if(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9._]+$/", $string)) {
            return 0;
        } else {
            return 1;
        }
    }
}