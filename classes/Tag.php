<?php

include_once(__DIR__ . "/Db.php");

class Tag{
    public static function getTags() {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Tags");
        $statement->execute();
        $tags = $statement->fetchAll();
        return $tags;
    }
    
    public function loadTagsByQuery($query){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM Posts WHERE tag1 LIKE :query");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();
        $foundTags = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $foundTags;
    }
}