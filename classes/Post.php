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

    public function get20lastFollowersPosts($id){
        
       // wtf waren wij eigenlijk aant doen? followerId ophqlen door te kijken naar followerId die we meegeven? 
       // dus gewoon de dingen die we erin stoppen ophalen?


       /* $ids = join(', ', $id);
        $conn = Db::getInstance();
        $result = $conn->prepare("select followerId from followers where followerId IN ($ids)");
        $result->execute();
        $followers = $result->fetchAll();*/


        // ALLES HIERBOVEN MAG DUS WEG
       
        // change array to mysql compatable version; (x,x,x)
        $ids = join(', ', $id);
        $conn = Db::getInstance();
        // get all posts from followers in $ids array in descending order qnd limited by 20 most recent
        $result = $conn->prepare("select * from posts where userId in ($ids) order by id desc limit 20 ");
        $result->execute();
        // save posts 
        $followersPosts = $result->fetchAll();
        return $followersPosts;

    }
    
}