<?php

include_once(__DIR__ . "/../interfaces/iPost.php");
include_once(__DIR__ . "/Dbnick.php");



class Post implements iPost{
 
    public function getAllPosts(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }
    public function getPostById(){}
    public function addPost(){}
    public function deletePost(){}

    public function get20LastPosts(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts order by id desc limit 20");
        return $result->fetchAll();

    }

    public function getPostByFollowerId(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts wher id=:id");
        return $result->fetchAll();
    }
    
}