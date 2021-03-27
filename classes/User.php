<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
include_once(__DIR__ . "/Db.php");
// implement: implements iUser
class User {
    
    public function getAll(){
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Users");
        $statement-> execute();
        $result = $statement->fetchAll();
        return $result;
        
        
    }
}