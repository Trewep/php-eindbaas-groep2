<?php
include_once('./../classes/Follower.php');

if(!empty($_POST)){

    $f = new Follower();
    $f->setUserId($_POST['userId']);
    $f->setFollowerId($_POST['followerId']);

    if($_POST['btn_value'] === 'follow'){
        $f->addFollower();
    }else{
        $f->deleteFollower();
    }




    $response= [
        'status'=> 'succes',
        'btn_state' => $_POST['btn_value'],
        'message' => 'follow added'
    ];


    header('Content-Type: application/json');
    echo json_encode($response);

}