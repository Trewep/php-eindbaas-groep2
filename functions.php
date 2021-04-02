<?php
//(profile)Image upload

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$error='';

// Check if image file is a actual image or fake image
if(!empty($_POST["submit"])) {

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $error = "File is not an image.";
      $uploadOk = 0;
    }
     // Check if file already exists
     if (file_exists($target_file)) {
      $uploadOk = 1;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      $error = "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && !empty($_FILES["file"]["name"])) {
      $error ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
  
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
   // $error = "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $avatar=basename( $_FILES["fileToUpload"]["name"]);
    //var_dump( $avatar);
    $user = new User();
    $user->setAvatar($avatar);
    $user->uploadAvatar($_SESSION["UserId"]);
    //header("Location: ownProfile.php");
  } else {
  }
  }
  }
  

  //Profile image delete
  
  if(!empty($_POST['delete'])){
    if (array_key_exists('delete_avatar', $_POST)) {
    $filename = $_POST['delete_avatar'];
    var_dump($filename);
    var_dump($target_dir . $filename);
    $file_dir = $target_dir . $filename;
    unlink($file_dir);
    }
    if (array_key_exists('delete_avatar', $_POST)) {
      $user = new User();
      $user->deleteAvatar($_SESSION["UserId"]);
      //header("Location: ownProfile.php");
    }
    else{
      $error = 'sorry your profile image has not been deleted please try again';

    }
  }
?>  