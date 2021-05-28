<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    session_start();

    include_once(__DIR__ . "/../classes/Comment.php");
    //include_once(__DIR__ . "/../classes/Time.php");
    
    function get_timeago($ptime) {
        $estimate_time = time() - $ptime;
    
        if ($estimate_time < 1) {
            return 'less than 1 second ago';
        }
    
        $condition = array(
            12 * 30 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );
    
        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;
    
            if ($d >= 1) {
                $r = round($d);
                return  $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }
    
    if(!empty($_POST)){
        //Nieuw comment object maken
        $c = new Comment();
        $c->setPostId($_POST['postId']);
        $c->setComment($_POST['comment']);
        $c->setUserId($_SESSION["userId"]);
        
        //Nieuw tijd object maken
        $date = new DateTime();
        $time = $date->getTimestamp();

        //Comment opslagen
        $c->save();

        //Succesboodschap teruggeven
        $response = [
            'status' => 'success',
            'userId' => htmlspecialchars($c->getUserId()),
            'user' => $_SESSION["username"],
            'body' => htmlspecialchars($c->getComment()),
            'time' => get_timeago($time),
            'message' => 'Comment saved'
        ];

        //Deze array teruggeven als JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>