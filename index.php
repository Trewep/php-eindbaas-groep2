<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$_SESSION["userId"] = 2;

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Follower.php");

$posts = new Post();

$followers = new Follower();
$followers= $followers->getFollowerByUserId($_SESSION["userId"]);

$array = [];
foreach ($followers as $follower){
    $array[] = $follower['followerId'];
  
}

if(!empty($followers)){
    //echo 'full';
    $posts = $posts->get20lastFollowersPosts($array);
}else{
    //echo 'empty';
    $posts = $posts->get20LastPosts();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A157&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
<?php include("header.inc.php") ?>

<?php foreach ($posts as $post) :?>
         <article>
     <h1>this is a post</h1>
     <a href="ownProfile.php?id=">Nickname</a>
     <p> post id = <?php echo htmlspecialchars($post['id'])?> </p>
 </article>
 <?php endforeach;?>


<?php include('nav.inc.php') ?>




</body>
</html>

