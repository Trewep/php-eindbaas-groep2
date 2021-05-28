<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once(__DIR__ . "/classes/Security.php");
Security::mustBeLoggedIn(); //not logged in no entry


$_SESSION["userId"];

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/Like.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Tag.php");

$user = new User();

$likes = new Like();

$posts = new Post();


//$allTags = $posts->getTags();

if(!empty($_GET)){
    $query = $_GET['search'];
    $foundUsers = $user->loadUsersByQuery($query);
    $foundTags = $posts->loadTagsByQuery($query);
    //var_dump($foundTags);
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/svg" href="assets/logo/logoIcon/iconDarkRed.svg">

    <title>Debuff</title>

    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--cssGram css-->
    <link rel="stylesheet" href="./css/cssGram.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A157&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <?php include("./header.inc.php") ?>
    <?php include("./desktopnav.inc.php")?>
    
    
    
        <div class="cardView">
            <form id="searchForm" action="" method="GET">
                <input type="text" name="search" id="search" placeholder="Search something">
                
                <input type="image" src="./assets/icons/blackIcons/type=search, state=Default.svg" border="0" alt="submit"/>
                <!--<input type="submit" value="🔍" id="login" class="searchbar">-->
            </form>
            <?php if(!empty($foundUsers)): ?>
                <ul>
                    <h5>Users</h5>
                    <?php foreach($foundUsers as $user): ?>
                        <li>
                            <a class="feedLink commentName" href="profile.php?id=<?php echo htmlspecialchars($user["id"]) ?>"><?php echo htmlspecialchars($user['username']); ?></a>
                            
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if(!empty($foundTags)): ?>
                <ul>
                    <h5>Tags</h5>
                    <?php foreach($foundTags as $tag): ?>
                        <li class="searchFormImage">
                            <a class="feedLink commentName" href="index.php?tag=<?php echo htmlspecialchars($tag["tag1"]) ?>"><img src="./postImages/<?php echo htmlspecialchars($tag['image']); ?>" alt="" width="250">
</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    
   

    <?php include('./desktopfooter.inc.php') ?>
    <?php include('./nav.inc.php') ?>

<script src="./javascript/like.js"></script>


</body>

</html>