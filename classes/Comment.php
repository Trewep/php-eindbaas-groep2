<?php

include_once(__DIR__ . "/../interfaces/iComment.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Dbnick.php");



class Comment implements iComment{

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

    public function getAllComments(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from comments");
        return $result->fetchAll();
    }



    public function getCommentById(){}
    public function addComment(){}
    public function deleteComment(){}


//haal het aantal rijen op waar de gegeven id gelijk is aan de userId
    public  function getCommentStats(){

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from comments where userId = :id");
        $result->bindValue(':id', $userId);
        $result->execute();
         $commentStats = $result->fetch();
         return  $commentStats;
    }
    

   
}