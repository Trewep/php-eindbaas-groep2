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
    
    <!--cssGram css-->
    <link rel="stylesheet" href="./css/cssGram.css">

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
                    </div>
                    <form method="POST">
                        <input type="submit" class="restore" name="<?php echo "restore" . $post['id'] ?>" value="Restore"/>
                        <input class="inappropriateDelete" type="submit" name="<?php echo "delete" . $post['id'] ?>" value="Delete"/>
                    </form>
                </article>
                
                
                
                <?php if(isset($_POST["restore" . $post['id']])): ?>
                    <?php
                        $inappropriatePost = new Post();
                        $inappropriatePost->setPostId($post['id']);
                        $inappropriatePost->restoreInappropriate();
                    ?>
                <?php endif; ?>
                <?php if(isset($_POST["delete" . $post['id']])): ?>
                    <?php
                        $target_dir = "postImages/";
                        $filename = $post['image'];
                        $file_dir = $target_dir . $filename;
                        unlink($file_dir);
                        $inappropriatePost = new Post();
                        $inappropriatePost->setPostId($post['id']);
                        $inappropriatePost->deleteInappropriate();
                        //header("location: index.php");
                    ?>
                <?php endif; ?>
<?php endforeach; ?>

         <?php include('./desktopfooter.inc.php') ?>
        <?php include('./nav.inc.php') ?>
        
        <!--<script>
            let restore = document.querySelector(".restore");
            restore.addEventListener("click", function(e){
                console.log("general kenobi");
            });
        </script>-->
</body>
</html>