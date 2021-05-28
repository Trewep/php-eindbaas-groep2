<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__ . "/../interfaces/iLike.php");
include_once(__DIR__ . "/Db.php");


class Like implements iLike
{

    private $userId;
    private $postId;
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
    public function setpostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    public function addLike(){
        $userId = $this->getUserId();
        $postId = $this->getPostId();
        $conn = Db::getConnection();
        $statement = $conn->prepare("insert into Likes (userId, postId) values (:userId, :postId)");
        $statement->bindValue(':userId', $userId );
        $statement->bindValue(':postId',  $postId);
        $result = $statement->execute();
        return $result;


    }
    public function deleteLike(){
        $userId = $this->getUserId();
        $postId = $this->getPostId();

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from Likes where userId = :userId and postId = :postId");
        $statement->bindValue(':userId', $userId );
        $statement->bindValue(':postId',  $postId);
        $result = $statement->execute();
        return $result;
    }
    
public static function getLikesByPostId($postId){
    //$postId = $this->getPostId();
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT COUNT(id) FROM Likes WHERE postId = :postId");
    $statement->bindValue(':postId',  $postId);
    $statement->execute();
    $testA = $statement->fetch();
    $test = $testA["COUNT(id)"];
    //var_dump($test);
    return $test;
}

 //haal het aantal rijen op waar de userId gelijk is aan de meegegeven id
    public function getLikeStats()
    {

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from Likes where userId = :id");
        $result->bindValue(':id',  $userId);
        $result->execute();
        $commentStats = $result->fetch();
        return  $commentStats;
    }
}