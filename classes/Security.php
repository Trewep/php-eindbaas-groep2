<?php

class Security{

    public static function mustBeLoggedIn(){
        if (!isset($_SESSION['username'])){
        header("location: login.php");
        };
    }

}