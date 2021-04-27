<?php

include_once(__DIR__ . "/../interfaces/iLike.php");
include_once(__DIR__ . "/Dbnick.php");


class Like implements iLike{

    public function getAllLikes(){}
    public function getLikeById(){}
    public function addLike(){}
    public function deleteLike(){}

    public  function getLikeStats($id){
        $conn = Db::getConnection();
        $result = $conn->prepare("select COUNT(*) from likes where userId = :id");
        $result->bindValue(':id', $id);
        $result->execute();
         $commentStats = $result->fetch();
         return  $commentStats;
    }
    
}