<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__ . "/../interfaces/iLike.php");
include_once(__DIR__ . "/Db.php");


class Like implements iLike{

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
    
    public function getAllLikes(){}
    public function getLikeById(){}

    public function addLike(){
        $userId = $this->getUserId();
        $postId = $this->getPostId();
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO Likes (userId, postId) VALUES(:userId, :postId)");
        $statement->bindValue(':userId', $userId );
        $statement->bindValue(':postId',  $postId);
        $result = $statement->execute();
        return $result;


    }
    public function deleteLike(){
        $userId = $this->getUserId();
        $postId = $this->getPostId();

        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM Likes WHERE userId = :userId AND postId = :postId");
        $statement->bindValue(':userId', $userId );
        $statement->bindValue(':postId',  $postId);
        $result = $statement->execute();
        return $result;
    }
    
    
public function getLikesByUserId($userId){
        $userId = $this->getUserId();
       $postId = $this->getPostId();
        
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT *FROM Likes WHERE userId = :userId");
        $statement->bindValue(':userId', $userId );
        //$statement->bindValue(':postId',  $postId);
        $statement->execute();
        $test = $statement->fetchAll();
         var_dump($test);
        return $test;

}
public static  function getLikesByPostId($postId){
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
}