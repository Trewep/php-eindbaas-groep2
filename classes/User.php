<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
include_once(__DIR__ . "/Db.php");

class User{
    public function getAll(){
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Users");
        $result = $statement->fetchAll();
    }
}