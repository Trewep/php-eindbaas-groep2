<?php
include_once('./../classes/Follower.php');

//als de post niet leeg is maak een nieuwe follower aan
if(!empty($_POST)){

    $f = new Follower();
    $f->setUserId($_POST['userId']);
    $f->setFollowerId($_POST['followerId']);

    //als de button waarde gelijk is aan follow voeg dan deze persoon toe aan de users followerlist - anders verwijder hem uit de list
    if($_POST['btn_value'] === 'follow'){
        $f->addFollower();
    }else{
        $f->deleteFollower();
    }
    
    //succes teruggeven
    $response= [
        'status'=> 'succes',
        'btn_state' => $_POST['btn_value'],
        'message' => 'follow added'
    ];


    //array teruggeven als JSON (momenteel HTML)
    header('Content-Type: application/json');
    echo json_encode($response);

}