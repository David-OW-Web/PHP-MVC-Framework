<?php

class DatabaseHandler
{
    private $con = null;

    public function getCon() {
        if(is_null($this->con)) {
            $this->con = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8", DB_USER, DB_PASSWORD);
        }
        return $this->con;
    }
}