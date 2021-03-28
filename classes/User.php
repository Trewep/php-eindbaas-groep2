<?php

include_once(__DIR__ . "/../interfaces/iUser.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Dbnick.php");

 
class User implements iUser {

    private $avatar;

     /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }






    
    public function getAllUsers(){
        //$conn = Db::getConnection();
        $conn = Db::getInstance();
        /*$statement = $conn->query("SELECT * FROM Users");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;*/
        $result = $conn->query("select * from user");
        return $result->fetchAll();

        
        
    }

    public function getUserById(int $id) {
        // only grab the videos for a certain user
        $conn = Db::getInstance();
        $result = $conn->prepare("select * from user where id = :id");
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetchAll();
    }

    public function addUser(){}
    public function deleteUser(){}

    
    public function uploadAvatar(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into user (ProfileImage) values (:avatar)");
        $statement->bindValue(':avatar', $this->avatar);
        var_dump('test');
        return $statement->execute();


    }


   
}