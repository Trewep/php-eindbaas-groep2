<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__.'/../classes/Like.php');

if(!empty($_POST)){

    $f = new Like();
    $f->setUserId($_POST['userId']);
    $f->setPostId($_POST['postId']);

    if($_POST['btn_value'] === "like"){
    
        $f->addLike();
    }else{
   
        $f->deleteLike();
    }

$response= [
       'status'=> 'success',
       'btn_state' => $_POST['btn_value'],
        'message' =>$_POST['btn_value']
   ];


    header('Content-Type: application/json');
    echo json_encode($response);
}