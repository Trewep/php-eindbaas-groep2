<?php

include_once(__DIR__ . "/../interfaces/iFollower.php");
include_once(__DIR__ . "/Db.php");


class Follower implements iFollower
{

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
 
    //get al the information (userID, FollowerID) off the people that the user is following 
    public function getFollowerByUserIdIndex()
    {
        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("SELECT * FROM Followers WHERE userId = :userId");
        $result->bindValue(':userId', $userId);
        $result->execute();
        return $result->fetchAll();
    }
    
      // haal het aantal rijen op waar de userId gelijk is aan de meegegeven id
    public  function getFollowerStats()
    {

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from Followers where userId = :id");
        $result->bindValue(':id', $userId);
        $result->execute();
        $commentStats = $result->fetch();
        return  $commentStats;
    }
    
       //haal de gegevens op van mensen die door de user gevold worden ( de profielpagina die je bezoekt)
    public function getFollowerByUserId()
    {

        $userId = $this->getUserId();
        $followerId = $this->getFollowerId();

        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from Followers where userId = :userId and followerId = :followerId");
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':followerId',  $followerId);
        $statement->execute();
        $test = $statement->fetch();
        return $test;
    }
    
        //voeg een follow toe aan de db
     public function addFollower()
    {

        $userId = $this->getUserId();
        $followerId = $this->getFollowerId();

        $conn = Db::getConnection();
        $statement = $conn->prepare("insert into Followers (userId, followerId) values (:userId, :followerId)");
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':followerId',  $followerId);
        $result = $statement->execute();
        return $result;
    }
    
    
    //verwijder een follow uit de db
    public function deleteFollower()
    {

        $userId = $this->getUserId();
        $followerId = $this->getFollowerId();

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from Followers where userId = :userId and followerId = :followerId");
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':followerId',  $followerId);
        $result = $statement->execute();
        return $result;
    }

   
}
