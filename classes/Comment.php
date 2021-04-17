<?php

include_once(__DIR__ . "/../interfaces/iComment.php");
include_once(__DIR__ . "/Db.php");


class Comment implements iComment{

    public function getAllComments(){
        $conn = Db::getConnection();
        $result = $conn->query("select * from Comments");
        return $result->fetchAll();
    }



    public function getCommentById(){}
    public function addComment(){}
    public function deleteComment(){}
    
}