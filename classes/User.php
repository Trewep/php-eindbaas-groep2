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
        $conn = Db::getInstance();

        $result = $conn->query("select * from users");
        return $result->fetchAll();

        
        
    }

    public static function getUserById(int $id) {
        // only grab the videos for a certain user
        $conn = Db::getInstance();
        $result = $conn->prepare("select * from users where id = :id");
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetch();
    }

    public function addUser(){}
    public function deleteUser(){}

    
    public function uploadAvatar($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("update users set profileImage=:avatar where id = :id ");
        $statement->bindValue(':avatar', $this->avatar);
        $statement->bindValue(':id', $id);
        $statement->execute();


    }

    public function deleteAvatar($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare('UPDATE users SET profileImage=:defaultAvatar WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->bindValue(':defaultAvatar', 'defaultAvatar');

        $statement->execute();

    }


   
}