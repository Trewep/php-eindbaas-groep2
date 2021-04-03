<?php
include_once('./../classes/Follower.php');

if(!empty($_POST)){



    $f = new Follower();
    $f->setUserId($_POST['userId']);
    $f->setFollowerId($_POST['followerId']);

    $f->addFollower();



    $response= [
        'status'=> 'succes',
        'message' => 'follow added'
    ];


    header('Content-Type: application/json');
    echo json_encode($response);

}