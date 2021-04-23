<?php
    var_dump($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview Tag</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A170&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
    <div id="posts">
        <?php
            //db connectie om alle posts op te halen die aan de aangeklikte tag voldoen
            $conn = new PDO('mysql:host=localhost;dbname=debuff', 'root', 'root');
            $statement = $conn->prepare("SELECT * FROM posts WHERE tags = :tags ORDER BY id DESC");
            $statement->bindValue(":tags", $_GET['tag']);
            $statement->execute();
            $posts = $statement->fetchAll();
        ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <img id="postImage" src= <?php echo "assets/testImages/" . $post['image'] ?> alt="">
                <p id="postDescription"><?php echo htmlspecialchars($post['description']) ?></p>
                <p id="postLocation"><?php echo htmlspecialchars($post['location']) ?></p>
                <!--Deze tag redirect naar een overview pagina waar alleen posts staan die deze tag hebben-->
                <a id="postTags" href="tagOverview.php?tag=<?php echo htmlspecialchars($post['tags']) ?>"><?php echo "#" . htmlspecialchars($post['tags']) ?></a>
                <p><?php echo $post['postTime'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>