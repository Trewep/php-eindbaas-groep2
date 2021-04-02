<?php

include_once(__DIR__ . "/../interfaces/iFollower.php");
include_once(__DIR__ . "/Dbnick.php");

class Follower implements iFollower {

    public function getAllFollowers(){
 
    }


    public static function getFollowerbyId(){}
    public function addFollower(){}
    public function deleteFollower(){}



public function getFollowerByUserId($id){
    $conn = Db::getInstance();
    $result = $conn->prepare("select * from followers where userId = :id");
    $result->bindValue(':id', $id);
    $result->execute();
    return $result->fetchAll();



}



}