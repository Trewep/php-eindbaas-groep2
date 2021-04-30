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

    $conn = Db::getConnection();
    $statement = $conn->prepare("insert into followers (userId, followerId) values (:userId, :followerId)");
    $statement->bindValue(':userId', $userId );
    $statement->bindValue(':followerId',  $followerId);
    $result = $statement->execute();
   return $result;
    }

    public function deleteFollower(){

    $userId = $this->getUserId();
    $followerId = $this->getFollowerId();

    $conn = Db::getConnection();
    $statement = $conn->prepare("delete from followers where userId = :userId and followerId = :followerId");
    $statement->bindValue(':userId', $userId );
    $statement->bindValue(':followerId',  $followerId);
    $result = $statement->execute();
    return $result;
    }



    public function getFollowerByUserId(){

    $userId = $this->getUserId();
    $followerId = $this->getFollowerId();
        
    $conn = Db::getConnection();
    $statement = $conn->prepare("select * from followers where userId = :userId and followerId = :followerId");
    $statement->bindValue(':userId', $userId );
    $statement->bindValue(':followerId',  $followerId);
    $statement->execute();
    $test = $statement->fetch();
    return $test;
    }

    //get al the information (userID, FollowerID) off the people that the user is following 
    public function getFollowerByUserIdIndex(){
    $userId = $this->getUserId();

    $conn = Db::getConnection();
    $result = $conn->prepare("select * from followers where userId = :userId");
    $result->bindValue(':userId', $userId );
    $result->execute();
    return $result->fetchAll();



}


// haal het aantal rijen op waar de userId gelijk is aan de meegegeven id
public  function getFollowerStats(){

    $userId = $this->getUserId();

    $conn = Db::getConnection();
    $result = $conn->prepare("select COUNT(*) from followers where userId = :id");
    $result->bindValue(':id', $userId);
    $result->execute();
     $commentStats = $result->fetch();
     return  $commentStats;
}


}