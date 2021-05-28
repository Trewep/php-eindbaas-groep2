<?php
include_once(__DIR__ . "/Db.php");
class Request{
    public function getRequests(){
        $userId = $_SESSION["userId"];
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Requests WHERE userId = :userId");
        $statement->bindValue(":userId", $userId);
        $statement->execute();
        $requests = $statement->fetchAll();
        return $requests;
    }
}