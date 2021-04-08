<?php

session_start();
$_SESSION["userId"] = 2;


include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Follower.php");

$profile = 'myProfile';

if(!empty($_GET['id'])){
    if($_GET['id'] == $_SESSION['userId']){

        $user = User::getUserById($_SESSION["userId"]);

    }else{
        $profile = 'otherProfile';
        $user = User::getUserById($_GET['id']);
    }
}else{
  

}




$followers = new Follower();
$followers= $followers->getFollowerByUserId($_SESSION["userId"]);

$btn_state = ' ';
 foreach ($followers as $follower){
    if($follower['followerId'] === $_GET['id']){
        $btn_state = 'Unfollow';
    }else{
        $btn_state ='Follow';
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
                <h1>JUSTNICK</h1>
            </div>

            <?php if($profile === 'otherProfile'):?>
            <div class='col-3 d-flex justify-content-end'>
            <button type="button" data-followerid="<?php echo htmlspecialchars($_GET['id'])?>" data-userid="<?php echo htmlspecialchars($_SESSION['userId'])?>" class="btn btn-danger"><?php echo htmlspecialchars($btn_state)?></button>
            </div>
            <?php endif; ?>

        </div>


        <?php if($profile === 'myProfile'):?>

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

            <div class="row">
                <div class="col-1"></div>
                <div class="col-10 d-flex flex-row">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row">
                <div class="col-1"></div>
                <div class="col-10 d-flex flex-row">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row">
                <div class="col-1"></div>
                <div class="col-10 d-flex flex-row">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                    <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg" alt="">
                </div>
                <div class="col-1"></div>
            </div>

        </div>

        <?php include('nav.inc.php') ?>

    </div>

    <script src="./javascript/profile.js"></script>

</body>

</html>