<?php
/*//(profile)Image upload
  $target_dir = "uploads/";

if(!empty($_POST["submit"])){

  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
}


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
  // if everything is ok, try to upload file
  } else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $avatar=basename( $_FILES["fileToUpload"]["name"]);
    $user = new User();
    $user->setAvatar($avatar);
    $user->uploadAvatar($_SESSION["userId"]);

  } else {
  }
  }
  }
  

  //Profile image delete
  if(!empty($_POST['delete'])){

    if (array_key_exists('delete_avatar', $_POST)) {
      $user = new User();
      $user->deleteAvatar($_SESSION["userId"]);
    }
    else{
      $error = 'sorry your profile image has not been deleted please try again';

    }
    if (array_key_exists('delete_avatar', $_POST)) {
    $filename = $_POST['delete_avatar'];
    var_dump($filename);
    var_dump($target_dir . $filename);
    $file_dir = $target_dir . $filename;
    unlink($file_dir);
    }
    
  }
*/
  
//get time and format it

function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return  $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}



