<?php
 //includes
    include_once(__DIR__ . "/classes/Post.php");
    include_once(__DIR__ . "/classes/Security.php");
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/Tag.php");
    include_once(__DIR__ . "/classes/Comment.php");
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
//show tags
$tags = new Tag();
$tags = $tags->getTags();
//show comments
$comments = new Comment();
$comments = $comments->getAllComments();

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
    <?php include("./desktopnav.inc.php")?>
    <?php foreach ($posts as $post) : ?>
<article>
                    <div class="articleBorder">
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
                            
                            <?php foreach ($tags as $tag) : ?>
                            <?php if ($post['tagId'] === $tag['id']) : ?>
                            <a id="postTags" href="index.php?tag=<?php echo htmlspecialchars($tag['name']) ?>"><?php echo htmlspecialchars($tag['name']) ?></a>
                            <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <!-- print de post image met bijhorende filter -->
                        <figure class="<?php echo htmlspecialchars($post['filter']) ?>">
                            <img class="feedImage" src="./postImages/<?php echo htmlspecialchars($post['image']) ?>" alt="">
                        </figure>
                    </div>
                    <!-- loop door alle comments en toon al de comments en de moment waarop ze gepost zijn -->
                    <?php foreach ($comments as $comment) : ?>
                        <?php if ($comment['postId'] === $post['id']) : ?>
                            <!-- als de userId bij een post gelijk is aan de userIdd van een comment print dan de gebruikersnaam -->
                            <?php foreach ($users as $user) : ?>
                                <?php if ($user['id'] === $comment['userId']) : ?>
                                    <div class="comment">
                                        <p><a class="feedLink commentName" href="profile.php?id=<?php echo htmlspecialchars($comment["userId"]) ?>">@<?php echo htmlspecialchars($user['username']) ?> </a></p>
                                        <p><?php echo htmlspecialchars($comment['comment']) ?></p>
                                        
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <hr>
                </article>
<?php endforeach; ?>

        <?php include('nav.inc.php') ?>
</body>
</html>