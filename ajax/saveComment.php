<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    session_start();

    include_once(__DIR__ . "/../classes/Comment.php");
    
    if(!empty($_POST)){
        //Nieuw comment object maken
        $c = new Comment();
        $c->setPostId($_POST['postId']);
        $c->setComment($_POST['text']);
        $c->setUserId($_SESSION["userId"]);

        //Comment opslagen
        $c->save();

        //Succesboodschap teruggeven
        $response = [
            'status' => 'success',
            'body' => htmlspecialchars($c->getComment()),
            'message' => 'Comment saved'
        ];

        //Deze array teruggeven als JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>