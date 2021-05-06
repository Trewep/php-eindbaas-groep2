<?php
include_once(__DIR__ . "/Db.php");
class Security{
    //control user is logged in
    public static function mustBeLoggedIn(){
        if (!isset($_SESSION['username'])){
        header("location: login.php");
        };
    }
    //control user is admin
    public static function mustBeAdmin(){
        $conn = Db::getConnection();
        $stm = $conn->prepare("select * from Users where username = :username");
        $stm->bindValue(':username', $_SESSION['username']);
        $stm->execute();
        $user = $stm->fetch();
        //var_dump($user);
        if(!$user){
            header("Location: index.php");
        } 
        if ($user['admin']!=1){
            header("Location: index.php");
        }
       
    }

}