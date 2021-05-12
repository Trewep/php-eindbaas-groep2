<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Security.php");

session_start();
Security::mustBeLoggedIn();
$_SESSION["userId"];

try {
    //wanneer op "Post image" geduwd wordt
    if(!empty($_POST["submit"])) {
        $filter = $_POST['filters'];
        $description = $_POST['description'];
        $tag = $_POST['tag'];
        //var_dump($_POST['tag']);

        $location = $_POST['location'];
        
        $post = new Post();
        $post->addPost($_SESSION["userId"], $filter, $description, $tag, $location);
    }
} catch (\Throwable $th) {
    //toont errors bij een lege description of image, of bij een fout filetype
    $error = $th->getMessage();
}

$filters = ['#nofilter','1977','Aden','brannan','brooklyn','clarendon','earlybird','gingham','hudson','inkwell','kelvin','lark','lo-Fi','maven','mayfair','moon',
'nashville','perpetua','reyes','rise','slumber','stinson','toaster','valencia','walden','willow','x-pro II'];

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

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A154&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
    <?php include("./header.inc.php") ?>
    <?php include("./desktopnav.inc.php")?>

    <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
    <!--enctype specifieert welk content type gebruikt moet worden wanneer het formulier gesubmit moet worden-->
        <?php if(isset($error)): ?>
            <p class="error"><?php echo $error ?></p>
        <?php endif; ?>
        <h1>Upload photo</h1>
        <div id="uploadPhoto">
            <img id="uploadIcon" src="assets/icons/blackIcons/type=share, state=Default.svg" alt="">
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
            <label for="description">Description</label>
            <textarea id="uploadDescriptionText" name="description" rows="4" cols="50" placeholder="Add a description"></textarea>
        </div>
        <div id="uploadLocation" class="uploadText">
            <label for="location">Location</label>
            <input id="uploadLocationText" type="text" name="location" placeholder="Add a location">
        </div>
        <div id="uploadTags" class="uploadText">
            <label for="tags">Tags</label>
            <input id="uploadTagsText" type="text" name="tag" placeholder="Add a tag">
        </div>
        <input id="uploadSubmit" type="submit" value="Post image" name="submit">
    </form>
    <?php include('./desktopfooter.inc.php') ?>
    <?php include('./nav.inc.php') ?>
</body>
</html>