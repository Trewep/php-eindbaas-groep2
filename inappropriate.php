<?php
 //includes
    include_once(__DIR__ . "/classes/Post.php");
    include_once(__DIR__ . "/classes/Security.php");
    include_once(__DIR__ . "/classes/User.php");
 //session
    session_start();
    $_SESSION["userId"];
//acces control
    Security::mustBeAdmin();
//show inappropriate posts
    $posts = new Post();
    $posts = $posts->getInappropriatePosts();
//show user info
$users = new User();
$users = $users->getAllUsers();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/svg"  href="assets/logo/logoIcon/iconDarkRed.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inappropriate</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A187&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
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

    <hr>
</article>
<?php endforeach; ?>

        <?php include('nav.inc.php') ?>
</body>
</html>