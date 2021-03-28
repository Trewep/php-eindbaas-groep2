<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/../bootstrap/bootstrap.php");
 
class User implements iUser {
    
    public function getAllUsers(){
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Users");
        $statement-> execute();
        $result = $statement->fetchAll();
        return $result;
        
        
    }

    public function getUserById(){}
    public function addUser(){}
    public function deleteUser(){}
}