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
include_once(__DIR__ . "/classes/Location.php");

$likes = new Like();

$posts = new Post();

$tags = new Tag();
$tags = $tags->getTags();
//var_dump($tags);

foreach($posts as $po){
    $location = Location::getLocations($po['location']);
}

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
if (!empty($_GET['tag'])) {
    $posts->setTag($_GET['tag']);
  $posts = $posts->getPostsByTag();
    //var_dump($posts);
} elseif(!empty($_GET['location'])) {
$posts = $posts->getPostsByLocation($_GET['location']);
      //var_dump($posts);
  }elseif(!empty($_GET['postid'])) {
$posts = Post::getPostByPostId($_GET['postid']);
  }else {
    if (!empty($followers)) {
        $posts = $posts->setFollowersArray($array);
        $posts = $posts->get20lastFollowersPosts();
    } else {
        $posts = $posts->get20LastPosts();
    }
}




//haal alle comments op
$comments = new Comment();
$comments = $comments->getAllComments();



//haal alle users op
$users = new User();
$users = $users->getAllUsers();

//get time and format it
//https://www.w3schools.in/php-script/time-ago-function/
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

    <title>Debuff - Homefeed</title>

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
    <?php include("./desktopnav.inc.php") ?>
    <?php $counter = 0; ?>



    <!-- loop door alle gevraagde posts en print de layout hiervoor -->
    <?php foreach ($posts as $post) : ?>
        <?php $like = Post::isLiked($post['id'], $_SESSION["userId"]);
        //var_dump($_SESSION["userId"]);

        ?>
        <div class="row">
            <div class="col">
                <article>
                    <div class="articleBorder">
                        <div class="feedProfileInfo">
                            <!-- loopt door alle users -->
                            <?php foreach ($users as $user) : ?>
                                <!-- als de userId bij een post gelijk is aan een id van een users print dan profile image en gebruikersnaam -->
                                <?php if ($post['userId'] === $user['id']) : ?>
                                    <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                                        <div><a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($post["userId"]) ?>"><img class="feedProfile" src="./assets/images/defaultAvatar.png" alt=""></a></div>
                                    <?php else : ?>
                                        <div><a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($post["userId"]) ?>"><img class="feedProfile" src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt=""></a></div>
                                    <?php endif; ?>
                                    <div class=postNameLocation>
                                        <h1 class="feedProfileName"><a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($post["userId"]) ?>"><?php echo htmlspecialchars($user['username']) ?></a></h1>
                                        <?php if (!empty($post['location'])) : ?>
                                            <a class="postLocation" href="index.php?location=<?php echo htmlspecialchars($post['location']) ?>"><?php echo  htmlspecialchars($post['location']) ?></a>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <!-- print de post description -->
                        <div class=postDescTags>
                            <p class="postDescription"><?php echo htmlspecialchars($post['description']) ?></p>

                            <?php //foreach ($tags as $tag) : 
                            ?>
                            <?php //if ($post['tagId'] === $tag['id']) : 
                            ?>
                            <?php if (!empty($post['tag1'])) : ?>
                                <a class="postTags" href="index.php?tag=<?php echo htmlspecialchars($post['tag1']) ?>"><?php echo "#" . htmlspecialchars($post['tag1']) ?></a>
                            <?php endif; ?>
                            <?php if (!empty($post['tag2'])) : ?>
                                <a class="postTags" href="index.php?tag=<?php echo htmlspecialchars($post['tag2']) ?>"><?php echo "#" . htmlspecialchars($post['tag2']) ?></a>
                            <?php endif; ?>
                            <?php if (!empty($post['tag3'])) : ?>
                                <a class="postTags" href="index.php?tag=<?php echo htmlspecialchars($post['tag3']) ?>"><?php echo "#" . htmlspecialchars($post['tag3']) ?></a>
                            <?php endif; ?>
                            <?php //endif; 
                            ?>
                            <?php //endforeach; 
                            ?>

                        </div>
                        <!-- print de post image met bijhorende filter -->
                        <figure class="<?php echo htmlspecialchars($post['filter']) ?>">
                            <img class="feedImage" src="./postImages/<?php echo htmlspecialchars($post['image']) ?>" alt="">
                        </figure>
                        <!-- persoon die likes moet likes en time moet doen moet de feed interactions nog aanvullen -->
                        <div class="feedInteractions">
                            <div>
                                <?php if ($like == NULL) : ?>
                                    <img src="./assets/icons/blackIcons/type=heart, state=Default.svg" alt="" data-counter=" <?php echo $counter ?>" data-postid="<?php echo $post['id'] ?>" data-userid="<?php echo $_SESSION['userId'] ?>" class="like">
                                <?php else : ?>
                                    <img src="./assets/icons/redIcons/type=heart, state=selected.svg" alt="" data-counter=" <?php echo $counter ?>" data-postid="<?php echo $post['id'] ?>" data-userid="<?php echo $_SESSION['userId'] ?>" class="like">
                                <?php endif; ?>
                            </div>

                            <div>
                                <p><span class="countLikes"><?php echo (Like::getLikesByPostId($post['id'])) ?></span> likes</p>
                            </div>

                            <div>
                                <p><?php echo (get_timeago($post['time'])) ?></p>
                            </div>

                        </div>
                        <div class="post__comments__form">
                            <input type="text" class="commentText" placeholder="What's on your mind">
                            <a href="#" class="btn btnAddComment" data-postid="<?php echo htmlspecialchars($post['id']) ?>">Add comment</a>
                        </div>
                    </div>
                    <hr>
                    <div class="commentsWrapper"></div>
                    <!-- loop door alle comments en toon al de comments en de moment waarop ze gepost zijn -->
                    <?php foreach ($comments as $comment) : ?>
                        <?php if ($comment['postId'] === $post['id']) : ?>
                            <!-- als de userId bij een post gelijk is aan de userIdd van een comment print dan de gebruikersnaam -->
                            <?php foreach ($users as $user) : ?>
                                <?php if ($user['id'] === $comment['userId']) : ?>
                                
                                    <div class="comment">
                                        <p><a class="feedLink commentName" href="profile.php?id=<?php echo htmlspecialchars($comment["userId"]) ?>">@<?php echo htmlspecialchars($user['username']) ?> </a></p>
                                        <p><?php echo htmlspecialchars($comment['comment']) ?></p>
                                        <p class="time"><?php echo get_timeago($comment['time']) ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </article>
            </div>

        </div>

        <!--<div id="testcomment"></div>-->
        <!--<p><a class="feedLink commentName" href="profile.php?id=<?php //echo htmlspecialchars($comment["userId"]) ?>">@<?php //echo htmlspecialchars($user['username']) ?> </a></p>
            <p><?php //echo htmlspecialchars($comment['comment']) ?></p>
            <p class="time"><?php //echo get_timeago($comment['time']) ?></p>-->

        <?php $counter++; ?>
    <?php endforeach; ?>

    <?php include('./desktopfooter.inc.php') ?>
    <?php include('./nav.inc.php') ?>

    <script src="./javascript/like.js"></script>
    <script src="./javascript/comment.js"></script>

</body>

</html>