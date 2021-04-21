<?php

include_once(__DIR__ . "/../interfaces/iPost.php");
include_once(__DIR__ . "/Db.php");



class Post implements iPost{
 
    public function getAllPosts(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from Posts");
        return $result->fetchAll();
    }

    public function getPostById($id){
        $conn = Db::getConnection();
        $result = $conn->prepare("select * from Posts where userId = :id");
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetchAll();
        var_dump($result);
    }
    
    public function addPost(){}
    public function deletePost($image){

        $conn = Db::getConnection();
        $statement = $conn->prepare("delete from Posts where image = :image");
        $statement->bindValue(':image', $image );
        $result = $statement->execute();
       return $result;
    }
    public function get20LastPosts(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from Posts order by id desc limit 20");
        return $result->fetchAll();

    }

    public function get20lastFollowersPosts($id){
        
     
       
        $ids = join(', ', $id);
        $conn = Db::getConnection();
        // get all posts from followers in $ids array in descending order and limited by 20 most recent
        $result = $conn->prepare("select * from Posts where userId in ($ids) order by id desc limit 20 ");
        $result->execute();
        // save posts 
        $followersPosts = $result->fetchAll();
        return $followersPosts;

    }
    
}