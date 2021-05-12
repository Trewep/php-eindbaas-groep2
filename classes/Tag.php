<?php

// include_once(__DIR__ . "/../interfaces/iTag.php");
include_once(__DIR__ . "/Db.php");

class Tag /*implements iTag*/{
    public static function getTags() {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Tags");
        $statement->execute();
        $tags = $statement->fetchAll();
        return $tags;
    }
}