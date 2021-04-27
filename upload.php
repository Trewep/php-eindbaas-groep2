<?php

session_start();
 if (!isset($_SESSION['username'])){
     header("location: login.php");
 };
$_SESSION["userId"];

//wanneer op "Post image" geduwd wordt
if(isset($_POST["submit"])) {
    //het pad om de geuploade afbeelding in op te slagen
    $target = "assets/testImages/" . basename($_FILES["uploadFile"]["name"]);
    //het type bestand uitlezen zodat we later non-images kunnen tegenhouden
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    //connectie naar db
    $conn = new PDO('mysql:host=localhost;dbname=debuff', 'root', 'root');
    //alle data ophalen uit het ingestuurde formulier
    $filter = $_POST['filters'];

    if($imageFileType === "jpg" || $imageFileType === "png") {
        $image = $_FILES["uploadFile"]["name"];
        //resizeImage($image, $imageFileType , 500);
    } else {
        $imageError = "Please choose a valid png or jpg file";
    }
    
    //-----IMAGE FILTER PRUTSWERK-----
    // if($imageFileType === "jpg") {
    //     $image = imagecreatefromjpeg($_FILES["uploadFile"]["name"]);
    //     imagefilter($image, $filter);
    //     imagejpeg($image, "image.jpg");
    // }
    // $image = "new" . $_FILES["uploadFile"]["name"];
    
    if(!empty($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $descriptionError = "The description cannot be empty";
    }
    $location = $_POST['location'];
    $tags = $_POST['tags'];
    $postTime = time();

    //opgehaalde data opslagen in databank
    $statement = $conn->prepare("INSERT INTO posts (image, imageFileType, description, location, tags, postTime) VALUES (:image, :imageFileType, :description, :location, :tags, :postTime)");
    $statement->bindValue(":image", $image);
    $statement->bindValue(":imageFileType", $imageFileType);
    $statement->bindValue(":description", $description);
    $statement->bindValue(":location", $location);
    $statement->bindValue(":tags", $tags);
    $statement->bindValue(":postTime", $postTime);
    $statement->execute();
    //geuploade afbeelding in de images folder zetten
    if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target)) {
        $message = "Image uploaded succesfully. The image was a " . $imageFileType;
    } else {
        $message = "There was a problem posting the image";
    }
}

$filters = ['1977','Aden','Brannan','Brooklyn','Clarendon','Earlybird','Gingham','Hudson','Inkwell','Kelvin','Lark','Lo-Fi','Maven','Mayfair','Moon',
'Nashville','Perpetua','Reyes','Rise','Slumber','Stinson','Toaster','Valencia','Walden','Willow','X-pro II'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <link rel="stylesheet" href="./css/cssGram.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A154&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
    <header class="test"></header>

    <figure class="kelvin">
        <img src="./assets/images/adrienguh-Afm_5kfVUxM-unsplash.jpg">
      </figure>

    <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
    <!--enctype specifieert welk content type gebruikt moet worden wanneer het formulier gesubmit moet worden-->
        <h1>Upload photo</h1>
        <div id="uploadPhoto">
            <?php if(isset($imageError)): ?>
                <p class="error"><?php echo $imageError ?></p>
            <?php endif; ?>
            <img id="uploadIcon" src="assets/icons/blackIcons/cloud-computing.png" alt="">
            <input id="uploadFile" type="file" name="uploadFile">
        </div>
        <div id="uploadFilter">
            <label for="filters">Choose a filter:</label>
            <select id="filters" name="filters">
            <?php foreach($filters as $value):?>
              <option value="<?php echo htmlspecialchars($value)?>"><?php echo htmlspecialchars($value)?></option>
              <?php endforeach;?>
            </select>
        </div>
        <div id="uploadDescription" class="uploadText">
            <?php if(isset($descriptionError)): ?>
                <p class="error"><?php echo $descriptionError ?></p>
            <?php endif; ?>
            <label for="description">Description</label>
            <textarea id="uploadDescriptionText" name="description" rows="4" cols="50" placeholder="Add a description"></textarea>
        </div>
        <div id="uploadLocation" class="uploadText">
            <label for="location">Location</label>
            <input id="uploadLocationText" type="text" name="location" placeholder="Add a location">
        </div>
        <div id="uploadTags" class="uploadText">
            <label for="tags">Tags</label>
            <input id="uploadTagsText" type="text" name="tags" placeholder="Add some tags">
        </div>
        <input id="uploadSubmit" type="submit" value="Post image" name="submit">
    </form>
    <div id="posts">
        <?php
            //db connectie om alle posts op te halen (inclusief de post die jij eventueel net gemaakt hebt)
            $conn = new PDO('mysql:host=localhost;dbname=debuff', 'root', 'root');
            $statement = $conn->query("SELECT * FROM posts ORDER BY id DESC");
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
    <nav class="test"></nav>
</body>
</html>