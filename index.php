<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$_SESSION["userId"] = 2;

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/functions.php");



$posts = new Post();

$followers = new Follower();
$followers = $followers->getFollowerByUserId($_SESSION["userId"]);

$array = [];
foreach ($followers as $follower) {
    $array[] = $follower['followerId'];
}

if (!empty($followers)) {
    //echo 'full';
    $posts = $posts->get20lastFollowersPosts($array);
} else {
    //echo 'empty';
    $posts = $posts->get20LastPosts();
}

$comments = new Comment();
$comments = $comments->getAllComments();
//var_dump($comments);

$users = new User();
$users = $users->getAllUsers();


foreach($comments as $comment){
    $timePosted = get_timeago($comment['time'] );
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debuff</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A157&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <?php include("header.inc.php") ?>

    <?php foreach ($posts as $post) : ?>
        <article>
            <!-- hier moeten echte gegevns nog gelust worden door persoon die de feature om post te maken heeft-->
            <img style="width: 8%;" src="./assets/images/default-profile-picture.jpg" alt="">
            <h1> <a href="profile.php?id=<?php echo htmlspecialchars($_SESSION["userId"]) ?>">Nickname</a></h1>
            <p> post id = <?php echo htmlspecialchars($post['id']) ?> </p>
            <p>hier komt description</p>
            <p>hier komen tags</p>
            <img style="width: 25%;" src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
            <div>hier komen iconen enz</div>
        </article>
        <?php foreach($comments as $comment):?>
        <?php if($comment['postId'] === $post['id']):?>
        <?php foreach($users as $user):?>
        <?php if($user['id'] === $comment['userId']):?>
        <div>
        <p><?php echo htmlspecialchars('@'.$user['username'])?></p>
        <p><?php echo htmlspecialchars($comment['comment'])?></p>
        <p><?php echo get_timeago($comment['time'])?></p>
        </div>
        <?php endif;?>
        <?php endforeach;?>
        <?php endif;?>
            <?php endforeach;?>
            <hr>
    <?php endforeach; ?>
   


    <?php include('nav.inc.php') ?>




</body>

</html>