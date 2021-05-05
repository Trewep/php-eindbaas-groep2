<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();
include_once(__DIR__ . "/classes/Security.php");
Security::mustBeLoggedIn(); //not logged in no entry
$_SESSION["userId"];

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Follower.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Like.php");
include_once(__DIR__ . "/functions.php");
$posts = new Post();
$likes = new Like();

$followers = new Follower();
$followers = $followers->getFollowerByUserId($_SESSION["userId"]);

$posts = new Post();

$followers = new Follower();
$followers = $followers->getFollowerByUserId2($_SESSION["userId"]);

$array = [];
foreach ($followers as $follower) {
    $array[] = $follower['followerId'];
}


if (!empty($followers)) {
    //echo 'full';
    $posts = $posts->get20lastFollowersPosts($array);
} else {
  //  echo 'empty';
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
    <link rel="shortcut icon" type="image/svg"  href="assets/logo/logoIcon/iconDarkRed.svg">
    <title>Debuff</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A157&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <?php include("./header.inc.php") ?>

    <?php foreach ($posts as $post) : ?>
        <?php $like = Post::isLiked($post['id'],$_SESSION["userId"]);
            //var_dump($_SESSION["userId"]);
            
        ?>

<article>
    <!-- hier moeten echte gegevns nog gelust worden door persoon die de feature om post te maken heeft-->
    <div class="feedProfileInfo">
        <?php foreach ($users as $user) : ?>
            <?php if ($post['userId'] === $user['id']) : ?>
                <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                    <div><img class="feedProfile" src="./assets/images/default-profile-picture.jpg" alt=""></div>
                <?php else : ?>
                    <div><img class="feedProfile" src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt=""></div>
                <?php endif; ?>
                <div>
                    <h1> <a class="feedLink" href="profile.php?id=<?php echo htmlspecialchars($post["userId"]) ?>"><?php echo htmlspecialchars($user['username']) ?> </a></h1>
                    <p>location</p>
                </div>

                <p>...</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div>
        <p>hier komt description</p>
        <p>hier komen tags</p>
    </div>

    <img class="feedImage" src="./assets/images/<?php echo htmlspecialchars($post['image']) ?>" alt="">

    <div class="feedInteractions">
        <div>
        <?php if ($like == NULL):?>
        <img src="./assets/icons/blackIcons/type=heart, state=Default.svg" alt="" data-postid="<?php echo $post['id'] ?>" data-userid="<?php echo $_SESSION['userId']?>" class="like">
        <?php else:?>
            <img src="./assets/icons/redIcons/type=heart, state=selected.svg" alt="" data-postid="<?php echo $post['id'] ?>" data-userid="<?php echo $_SESSION['userId']?>" class="like">
        <?php endif;?>
        </div>

        <div>
            <p><?php  echo (Like::getLikesByPostId($post['id'])) ?> likes</p>
        </div>

        <div>
            <p>x days ago</p>
        </div>

    </div>

    <?php foreach ($comments as $comment) : ?>
        <?php if ($comment['postId'] === $post['id']) : ?>
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


    <script src="./javascript/like.js"></script>

</body>

</html>