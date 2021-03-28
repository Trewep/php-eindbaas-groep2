<?php
    abstract class Db {
        private static $conn;

        public static function getInstance(){
            if(self::$conn != null){
                echo "er is connectie";
                // connection found, return connection
                return self::$conn;
            } else{
                self::$conn = new PDO('mysql:host=127.0.0.1;dbname=debuff', 'root', 'root');
                return self::$conn;
            }
            
        }
    }