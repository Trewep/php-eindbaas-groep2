<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
};
$_SESSION["userId"];

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/functions.php");


$posts = new Post();

//get the id's from the people the user is following
$followers = new Follower();
$followers = $followers->setUserId($_SESSION["userId"]);
$followers = $followers->getFollowerByUserIdIndex();

// make an array with al the id's off the people that user is following
$array = [];
foreach ($followers as $follower) {
    $array[] = $follower['followerId'];
}

//If users is following people show their posts - else show 20 last posts posted
if (!empty($followers)) {
    //echo 'full';
    $posts = $posts->setFollowersArray($array);
    $posts = $posts->get20lastFollowersPosts();
} else {
    //echo 'empty';
    $posts = $posts->get20LastPosts();
}

//haal alle comments op
$comments = new Comment();
$comments = $comments->getAllComments();

//haal alle users op
$users = new User();
$users = $users->getAllUsers();

//get time and format it

function get_timeago($ptime)
{
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

//haal de time unix timestamp op en zet om naar leesbare tijd
foreach ($comments as $comment) {
    $timePosted = get_timeago($comment['time']);
}
?>

<!DOCTYPE html>
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

<!-- loop door alle gevraagde posts en print de layout hiervoor -->
    <?php foreach ($posts as $post) : ?>

        <article>
            <div class="feedProfileInfo">
<!-- loopt door alle users -->
                <?php foreach ($users as $user) : ?>
<!-- als de userId bij een post gelijk is aan een id van een users print dan profile image en gebruikersnaam -->
                    <?php if ($post['userId'] === $user['id']) : ?>
                        <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                            <div><img class="feedProfile" src="./assets/images/default-profile-picture.jpg" alt=""></div>
                        <?php else : ?>
                            <div><img class="feedProfile" src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt=""></div>
                        <?php endif; ?>
                        <div>
                            <h1> <a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($post["userId"]) ?>"><?php echo htmlspecialchars($user['username']) ?> </a></h1>
                            <p><?php echo htmlspecialchars($post['location']) ?></p>
                        </div>
                        <p>...</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
<!-- print de post description -->
            <div>
                <p><?php echo htmlspecialchars($post['description']) ?></p>
                <p>hier komen tags</p>
            </div>
<!-- print de post image met bijhorende filter -->
            <figure class="<?php echo htmlspecialchars($post['filter']) ?>">
                <img class="feedImage" src="./postImages/<?php echo htmlspecialchars($post['image']) ?>" alt="">
            </figure>
<!-- persoon die likes moet likes en time moet doen moet de feed interactions nog aanvullen -->
            <div class="feedInteractions">
                <div>
                    <img src="./assets/icons/blackIcons/type=heart, state=Default.svg" alt="">
                    <img src="./assets/icons/blackIcons/type=message, state=Default.svg" alt="">
                </div>

                <div>
                    <p>x likes</p>
                </div>

                <div>
                    <p>x days ago</p>
                </div>

            </div>
<!-- loop door alle comments en toon al de comments en de moment waarop ze gepost zijn -->
            <?php foreach ($comments as $comment) : ?>
                <?php if ($comment['postId'] === $post['id']) : ?>
<!-- als de userId bij een post gelijk is aan de userIdd van een comment print dan de gebruikersnaam -->
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] === $comment['userId']) : ?>
                            <div>
                                <p><a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($comment["userId"]) ?>">@<?php echo htmlspecialchars($user['username']) ?> </a></p>
                                <p><?php echo htmlspecialchars($comment['comment']) ?></p>
                                <p><?php echo get_timeago($comment['time']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <hr>
        </article>

    <?php endforeach; ?>




    <?php include('./nav.inc.php') ?>




</body>

</html>