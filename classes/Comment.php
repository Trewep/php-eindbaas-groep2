<?php

include_once(__DIR__ . "/../interfaces/iComment.php");
//include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/../bootstrap/bootstrap.php");

class Comment implements iComment{

    public function getAllComments(){}
    public function getCommentById(){}
    public function addComment(){}
    public function deleteComment(){}
    
}