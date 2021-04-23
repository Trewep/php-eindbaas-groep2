<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
 
 
session_start();
    
 if (!isset($_SESSION['username'])){
     header("location: login.php");
 };

$_SESSION["userId"];
//var_dump($_SESSION["userId"]);



include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Post.php");

$profile = 'myProfile';


if (!empty($_GET['id'])) {
    if ($_GET['id'] == $_SESSION['userId']) {

        $user = User::getUserById($_SESSION["userId"]);
    } else {
        $profile = 'otherProfile';
        $user = User::getUserById($_GET['id']);
    }
} else {
}




$follower = new Follower();
$follower->setFollowerId($_GET['id']);
$follower->setUserId($_SESSION["userId"]);
$follower = $follower->getFollowerByUserId();
var_dump($follower);

if($follower != null){
if($follower['followerId'] === $_GET['id'] ){
    $followerButton = 'unfollow';
}else{
        $followerButton = 'follow';

}
}else{
            $followerButton = 'follow';

}


if (!empty($_POST)) {

    $target_dir = "uploads/";
    //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
}


$posts = new Post();
$postsId = $posts->getPostById($_GET['id']);
//var_dump($postsId);

if (!empty($_POST['deletePostBtn'])) {

    if (array_key_exists('deletePost', $_POST)) {
        //var_dump($_POST['deletePost']);
        $posts->deletePost($_POST['deletePost']);
        header("location: ./profile.php?id=".$_GET['id']);

    } else {
        /* $error = 'sorry something went wrong please try again';*/
    }
   if (array_key_exists('deletePost', $_POST)) {
        $filename = $_POST['deletePost'];
        //var_dump($filename);
        //var_dump($target_dir . $filename);
        $file_dir = $target_dir . $filename;
        unlink($file_dir);
        header("location: ./profile.php?id=".$_GET['id']);
    } else {
    }
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Own profile</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A173&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <div class="container">

        <?php include("header.inc.php") ?>

        <div class="row no-gutters profileOptions">

            <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                <div class="col-3 d-flex justify-content-end"><img src="./assets/images/default-profile-picture.jpg" alt=""></div>
            <?php else : ?>
                <div class="col-3 d-flex justify-content-end"><img src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt=""></div>
            <?php endif; ?>

            <div class="col-3 d-flex justify-content-start">
                <h1><?php echo htmlspecialchars($user['username']) ?></h1>
            </div>

            <?php if ($profile === 'otherProfile') : ?>
                <div class='col-3 d-flex justify-content-end'>
                    <button type="button" data-followerid="<?php echo $_GET['id'] ?>" data-userid="<?php echo $_SESSION['userId'] ?>" class="btn btn-danger"><?php echo $followerButton ?></button>
                </div>
            <?php endif; ?>

        </div>


        <?php if ($profile === 'myProfile') : ?>

            <div class="row no-gutters profileButtons">

                <div class="col-5 d-flex flex-row ProfileButton justify-content-center">
                    <img src="./assets/icons/blackIcons/type=menu, state=Default.svg" alt="">
                    <a href="./profileSettings.php">settings</a>
                </div>

                <div class="col-5 d-flex flex-row ProfileButton justify-content-center">
                    <img src="./assets/icons/blackIcons/type=person, state=Default.svg" alt="">
                    <a href="./profileSettings.php">admin page</a>

                </div>

            </div>
        <?php endif; ?>


        <hr>
        
        <div class="imageOverview">
            <?php foreach ($postsId as $post) : ?>
                <?php if($post['userId'] == $_GET['id']):?>
                                    <?php //var_dump($post['userId'])?>
                <div class="row">
                    <div class="col-5 d-flex flex">
                        <div class="imageContainer">
                            <img src="./uploads/<?php echo htmlspecialchars($post['image'])?>" alt="">
                            <?php if ($profile === 'myProfile') : ?>
                            <form action="" method="POST">
                                <input type="hidden" name="deletePost" value="<?php echo htmlspecialchars($post['image'])?>">
                                <input type="submit" class="btn btn-danger btnDelete" value="delete" name="deletePostBtn">
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <?php include('nav.inc.php') ?>


        <script src="./javascript/profile.js"></script>

</body>

</html>