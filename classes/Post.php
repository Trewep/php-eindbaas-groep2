<?php

include_once(__DIR__ . "/../interfaces/iPost.php");
include_once(__DIR__ . "/Dbnick.php");



class Post implements iPost{

    private $followersArray;
    private $userId;

    /**
     * Get the value of followersArray
     */ 
    public function getFollowersArray()
    {
        return $this->followersArray;
    }

    /**
     * Set the value of followersArray
     *
     * @return  self
     */ 
    public function setFollowersArray($followersArray)
    {
        $this->followersArray = $followersArray;

        return $this;
    }

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
 
    public function getAllPosts(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }
    public function getPostById(){}

    
//haal de gegevens op van posts waar de userId gelijk is aan de meegegevn id
    public function getPostByuserId(){

        $userId = $this->getUserId();

        $conn = Db::getConnection();
        $result = $conn->prepare("select * from posts where userId = :id");
        $result->bindValue(':id', $userId);
        $result->execute();
        return $result->fetchAll();
        var_dump($result);
    }
    
    public function addPost(){}
    public function deletePost($image){

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from posts where image = :image");
        $statement->bindValue(':image', $image );
        $result = $statement->execute();
       return $result;
    }
    public function get20LastPosts(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from posts order by id desc limit 20");
        return $result->fetchAll();

    }



    //use array with id's from people user is following to get 20 last followers post
    public function get20lastFollowersPosts(){

        $followersArray = $this->getFollowersArray();

        //make a single line from array
        $ids = join(', ', $followersArray);
        $conn = Db::getConnection();
        // get all posts from followers in $ids array in descending order and limited by 20 most recent
        // $ids is safe becquse the values come from database/ no input from front-end
        // deze manier navragen joris https://stackoverflow.com/questions/920353/can-i-bind-an-array-to-an-in-condition
        $result = $conn->prepare("select * from posts where userId in ($ids) order by id desc limit 20 ");
        //$result->bindValue(':ids',  $ids );
        $result->execute();
        // save posts 
        $followersPosts = $result->fetchAll();
        return $followersPosts;
    }

    public function getFilter(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }

    public function removeFilter($image, $id){
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE posts SET filter = '#nofilter' where image = :image AND userId = :userId ");
        $statement->bindValue(':image', $image );
        $statement->bindValue(':userId', $id );
        $statement->execute();
    }
    




}