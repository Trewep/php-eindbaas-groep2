<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Dbnick.php");

 
class User implements iUser {
    
    public function getAllUsers(){
        //$conn = Db::getConnection();
        $conn = Db::getInstance();
        /*$statement = $conn->query("SELECT * FROM Users");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;*/
        $conn = Db::getInstance();
        $result = $conn->query("select * from user");
        return $result->fetchAll();

        
        
    }

    public function getUserById(){}
    public function addUser(){}
    public function deleteUser(){}
}