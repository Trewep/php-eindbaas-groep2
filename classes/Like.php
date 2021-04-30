<?php

include_once(__DIR__ . "/../interfaces/iLike.php");
include_once(__DIR__ . "/Dbnick.php");


class Like implements iLike{

    private $userId;

     /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAllLikes(){}
    public function getLikeById(){}
    public function addLike(){}
    public function deleteLike(){}

    //haal het aantal rijen op waar de userId gelijk is aan de meegegeven id
    public  function getLikeStats(){

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from likes where userId = :id");
        $result->bindValue(':id',  $userId);
        $result->execute();
         $commentStats = $result->fetch();
         return  $commentStats;
    }
    

   
}