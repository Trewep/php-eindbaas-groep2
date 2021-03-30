<?php

include_once(__DIR__ . "/classes/User.php");

$user = User::getUserById(2);


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));




// Check if image file is a actual image or fake image
if(!empty($_POST["submit"])) {
  

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

    // Check if file already exists
    if (file_exists($target_file)) {
      $uploadOk = 1;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && !empty($_FILES["file"]["name"])) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    $avatar=basename( $_FILES["fileToUpload"]["name"]);
    //var_dump( $avatar);
    $user = new User();
    $user->setAvatar($avatar);
    $user->uploadAvatar(2);
    header("Location: profileSettings.php");
  } else {
  }
}

if(!empty($_POST['delete_avatar'])){
  if (array_key_exists('delete_avatar', $_POST)) {
    $user = new User();
    $user->deleteAvatar(2);
    header("Location: profileSettings.php");
  }
}




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
<input type="hidden" name="delete_avatar">
<button name="delete_avatar" type="submit">Delete</button>
</form>

</div>





</body>
</html>

    
</body>
</html>