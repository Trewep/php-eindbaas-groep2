<?php

include_once(__DIR__ . "/Db.php");
class Location{
    public static function getLocations($location) {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM Post WHERE location = :locations");
        $statement->bindValue(':location', $location);
        $statement->execute();
        $location = $statement->fetchAll();
        return $location;
    }
}