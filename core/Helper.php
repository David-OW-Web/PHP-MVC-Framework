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
}