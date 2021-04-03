<?php

include_once(__DIR__ . "/../interfaces/iFollower.php");
include_once(__DIR__ . "/Dbnick.php");

class Follower implements iFollower {

    private $userId;
    private $followerId;

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
     * Get the value of followerId
     */ 
    public function getFollowerId()
    {
        return $this->followerId;
    }

    /**
     * Set the value of followerId
     *
     * @return  self
     */ 
    public function setFollowerId($followerId)
    {
        $this->followerId = $followerId;

        return $this;
    }

    public function getAllFollowers(){
 
    }


    public static function getFollowerbyId(){}


    public function addFollower(){

        $userId = $this->getUserId();
        $followerId = $this->getFollowerId();



    $conn = Db::getInstance();
    $statement = $conn->prepare("insert into followers (userId, followerId) values (:userId, :followerId)");
    $statement->bindValue(':userId', $userId );
    $statement->bindValue(':followerId',  $followerId);
    $result = $statement->execute();
   return $result;

    }

    public function deleteFollower(){}



public function getFollowerByUserId($id){
    $conn = Db::getInstance();
    $result = $conn->prepare("select * from followers where userId = :id");
    $result->bindValue(':id', $id);
    $result->execute();
    return $result->fetchAll();



}





}