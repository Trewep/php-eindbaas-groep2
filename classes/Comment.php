<?php

include_once(__DIR__ . "/../interfaces/iComment.php");
include_once(__DIR__ . "/Db.php");



class Comment implements iComment{

    private $userId;
    private $comment;
    private $postId;
    private $time;

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
    
    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
    
    /**
     * Get the value of postId
     */ 
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set the value of postId
     *
     * @return  self
     */ 
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }
    
    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

//haal de gegevens op van alle comments
    public function getAllComments(){
        $conn = Db::getConnection();
        $result = $conn->query("SELECT * FROM Comments ORDER BY id DESC");
        $result->execute();
        return $result->fetchAll();
    }
    
    //haal het aantal rijen op waar de gegeven id gelijk is aan de userId
    public  function getCommentStats(){

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from Comments where userId = :id");
        $result->bindValue(':id', $userId);
        $result->execute();
         $commentStats = $result->fetch();
         return  $commentStats;
    }
    
    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO Comments (comment, postId, userId, time) VALUES (:comment, :postId, :userId, :time)");
        
        $comment = $this->getComment();
        $postId = $this->getPostId();
        $userId = $this->getUserId();
        $date = new DateTime();
        $time = $date->getTimestamp();

        $statement->bindValue(":comment", $comment);
        $statement->bindValue(":postId", $postId);
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":time", $time);

        $result = $statement->execute();
        return $result;
    }

}