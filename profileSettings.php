<?php

session_start();


include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/functions.php");


$user = User::getUserById($_SESSION["UserId"]);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A149&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>
<body>
<!DOCTYPE html>
<html>
<body>

<div class="row">
<div class="col-5">
<img src="./uploads/<?php echo htmlspecialchars($user['ProfileImage'])?>" alt="">
<p>Current Avatar</p>
</div>
<div class="col-5">
<form action="" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</div>

<form action="" method="post">
<label for="deleteAvatar"> Delete profile Picture</label>
<input type="hidden" name="delete_avatar" value="<?php echo htmlspecialchars($user['ProfileImage'])?>">
<button name="delete" type="submit" value="delete">Delete</button>
</form>

</div>





</body>
</html>

    
</body>
</html>