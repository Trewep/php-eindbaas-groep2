<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
};

$_SESSION["userId"];

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/Like.php");

//kijk of het de user zijn profiel is of dat van iemand anders
$profile;
if (!empty($_GET['id'])) {
    if ($_GET['id'] == $_SESSION['userId']) {
        $profile = 'myProfile';
    } else {
        $profile = 'otherProfile';
    }
} else {
}

//haal de gevens op van een user aan de hand van het id uit url
$user = new User;
$user = $user->setUserId($_GET['id']);
$user = $user->getUserById();

//haal het aantal geposte comments op van de users
$commentStats = new Comment;
$commentStat = $commentStats->setUserId($_GET['id']);
$commentStat = $commentStats->getCommentStats();

//haal het aantal gebruikers op die de user volgd
$followerStats = new Follower;
$followerStat = $followerStats->setUserId($_GET['id']);
$followerStat = $followerStats->getFollowerStats();

//haal het aantal likes op die de user al heeft gegeven
$likesStats = new Like;
$likesStat = $likesStats->setUserId($_GET['id']);
$likesStat = $likesStats->getlikeStats();

//haal de datum waarop de account aangemaakt is op
$dateStats = new User;
$dateStat = $dateStats->setUserId($_GET['id']);
$dateStat = $dateStats->getdateStats();

// haal de gegevens van een persoon die die user volgd op
$follower = new Follower();
$follower->setFollowerId($_GET['id']);
$follower->setUserId($_SESSION["userId"]);
$follower = $follower->getFollowerByUserId();
//als er geen volger is zet dan de subscribe button op follow - anders op unfollow
if ($follower != null) {
    if ($follower['followerId'] === $_GET['id']) {
        $followerButton = 'unfollow';
    } else {
        $followerButton = 'follow';
    }
} else {
    $followerButton = 'follow';
}

//haal de posts op die bij een bepaald userId horen
$posts = new Post();
$postsId = $posts->setUserId($_GET['id']);
$postsId = $posts->getPostByuserId();

//als de post niet leeg is zet de target directory 
if (!empty($_POST)) {
    $target_dir = "postImages/";
}

//als er op de deleteknop gedrukt wordt verwijder de image naam uit de db en de image uit de image directory
if (!empty($_POST['deletePostBtn'])) {

    if (array_key_exists('deletePost', $_POST)) {
        $posts->deletePost($_POST['deletePost']);
        header("location: ./profile.php?id=" . $_GET['id']);
    }

    if (array_key_exists('deletePost', $_POST)) {
        $filename = $_POST['deletePost'];
        $file_dir = $target_dir . $filename;
        unlink($file_dir);
        header("location: ./profile.php?id=" . $_GET['id']);
    }
}

//als er op de remove filter knop gedrukt wordt verwijder de filter uit de db
if (!empty($_POST['deleteFilterBtn'])) {

    if (array_key_exists('deleteFilter', $_POST)) {
        var_dump($_POST['deleteFilter']);
        $posts->removeFilter($_POST['deleteFilter'], $_GET['id']);
        header("location: ./profile.php?id=" . $_GET['id']);
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

    <!--cssGram css-->
    <link rel="stylesheet" href="./css/cssGram.css">


    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A173&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <div class="container">

        <?php include("header.inc.php") ?>

        <div class="row no-gutters profileOptions">

            <!-- check of de profielfoto van de eigenaar van het profiel gelijk is aan de defaultavatar of niet. Als het wels is wordt deze geprint anders de foto die in de db zit -->
            <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                <div class="col-3 d-flex justify-content-end"><img src="./assets/images/default-profile-picture.jpg" alt=""></div>
            <?php else : ?>
                <div class="col-3 d-flex justify-content-end"><img src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt=""></div>
            <?php endif; ?>

            <div class="col-3 d-flex justify-content-start">
                <h1><?php echo htmlspecialchars($user['username']) ?></h1>
            </div>
            <!-- als het profiel niet van de user is toon dan een follo/unfollow button-->
            <?php if ($profile === 'otherProfile') : ?>
                <div class='col-3 d-flex justify-content-end'>
                    <button type="button" data-followerid="<?php echo $_GET['id'] ?>" data-userid="<?php echo $_SESSION['userId'] ?>" class="btn btn-danger"><?php echo $followerButton ?></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- als het bezochte profiel het eigen profiel is toon dan de settings en admin options -->
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

        <!-- toon de profiel statistieken -->
        <div class="profileStats">
            <p>COMMENTS GIVEN: <?php echo htmlspecialchars($commentStat["COUNT(*)"]) ?></p>
            <p>PEOPLE FOLLOWED: <?php echo htmlspecialchars($followerStat["COUNT(*)"]) ?></p>
            <p>LIKES GIVEN: <?php echo htmlspecialchars($likesStat["COUNT(*)"]) ?></p>
            <p>ACCOUNT CREATED: <?php echo htmlspecialchars($dateStat['created']) ?></p>
        </div>

        <div class="imageOverview">
            <!-- loop over alle posts en als het userId van de post gelijk is aan de id in de url toon dan de image van deze post -->
            <?php foreach ($postsId as $post) : ?>
                <?php if ($post['userId'] == $_GET['id']) : ?>
                    <div class="row">
                        <div class="col-5 d-flex flex">
                            <div class="imageContainer">
                                <figure class="<?php echo htmlspecialchars($post['filter']) ?>">
                                    <img src="./postImages/<?php echo htmlspecialchars($post['image']) ?>" alt="">
                                </figure>
                                <!-- als het bezochte profiel het eigen profiel is toon dan de delete foto en remove filter button - als het een ander profiel is niet -->
                                <?php if ($profile === 'myProfile') : ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="deletePost" value="<?php echo htmlspecialchars($post['image']) ?>">
                                        <input type="submit" class="btn btn-danger btnDelete" value="delete" name="deletePostBtn">
                                    </form>
                                    <br>
                                    <form action="" method="POST">
                                        <input type="hidden" name="deleteFilter" value="<?php echo htmlspecialchars($post['image']) ?>">
                                        <input type="submit" class="btn btn-danger btnDelete" value="remove filter" name="deleteFilterBtn">
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