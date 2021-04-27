<?php

include_once(__DIR__ . "/../interfaces/iComment.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Dbnick.php");



class Comment implements iComment{

    public function getAllComments(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from comments");
        return $result->fetchAll();
    }



    public function getCommentById(){}
    public function addComment(){}
    public function deleteComment(){}

    public  function getCommentStats($id){
        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from comments where userId = :id");
        $result->bindValue(':id', $id);
        $result->execute();
         $commentStats = $result->fetch();
         return  $commentStats;
    }
    
}