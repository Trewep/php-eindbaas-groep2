<?php
    session_start();
    include_once(__DIR__ . "/classes/Security.php");
    Security::mustBeLoggedIn(); //not logged in no entry

    $_SESSION["userId"];
    
    include_once(__DIR__ . "/classes/Db.php");
    include_once(__DIR__ . "/classes/Request.php");
    
    $requests = new Request();
    $requests = $requests->getRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/svg" href="assets/logo/logoIcon/iconDarkRed.svg">
    <title>Requests</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">
    
    <!--cssGram css-->
    <link rel="stylesheet" href="./css/cssGram.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A167&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
    <?php include("./header.inc.php"); ?>
    <?php include("./desktopnav.inc.php"); ?>

    <div class="cardView">
        <h1>Work in progress</h1>
    </div>
    
    <?php include('./desktopfooter.inc.php'); ?>
    <?php include('./nav.inc.php'); ?>
</body>
</html>