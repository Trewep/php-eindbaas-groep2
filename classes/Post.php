<?php

include_once(__DIR__ . "/../interfaces/iPost.php");
include_once(__DIR__ . "/Dbnick.php");



class Post implements iPost{
 
    public function getAllPosts(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }

    public function getPostById($id){
        $conn = Db::getInstance();
        $result = $conn->prepare("select * from posts where userId = :id");
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetchAll();
    }



    public function addPost(){}
    public function deletePost(){}

    public function get20LastPosts(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts order by id desc limit 20");
        return $result->fetchAll();

    }

    public function get20lastFollowersPosts($id){
        
     
       
        $ids = join(', ', $id);
        $conn = Db::getInstance();
        // get all posts from followers in $ids array in descending order and limited by 20 most recent
        $result = $conn->prepare("select * from posts where userId in ($ids) order by id desc limit 20 ");
        $result->execute();
        // save posts 
        $followersPosts = $result->fetchAll();
        return $followersPosts;

    }
    
}