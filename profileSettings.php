<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

 if (!isset($_SESSION['username'])){
     header("location: login.php");
 };

$id =$_SESSION["userId"];


include_once(__DIR__ . "/classes/User.php");



//(profile)Image upload
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


$user = User::getUserById($_SESSION["userId"]);

if(!empty($_POST ["editEmail"])){
$editEmail = $_POST['editEmail'];

$u = new User;
$u->updateEmail($id, $editEmail);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/svg"  href="assets/logo/logoIcon/iconDarkRed.svg">
    <title>Profile Settings</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">

    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A149&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body>
    <!DOCTYPE html>
    <html>

    <body>

    <?php include("./header.inc.php") ?>


        <?php if (isset($error)) : ?>
            <div class='row'>
                <div class="col-1"></div>
                <div class="col-10 d-flex justify-content-center error">
                    <?php echo $error ?>
                </div>
                <div class="col-1"></div>
            </div>
        <?php endif; ?>



        <div class="profileSettingsImage">

            <div class="row">

                <div class="col-1"></div>

                <div class="col-5 d-flex justify-content-start ">
                    <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                        <img src="./assets/images/default-profile-picture.jpg" alt="">
                    <?php else : ?>
                        <img src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt="">
                    <?php endif; ?>

                </div>


                <div class="col-5 d-flex justify-content-end ">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="fileToUpload">Change profile picture</label>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                </div>

                <div class="col-1"></div>


                <div class="row">
                    <div class="col-12  d-flex justify-content-center">

                        <form action="" method="post">
                            <label for="deleteAvatar"> Delete profile Picture</label>
                            <input type="hidden" name="delete_avatar" value="<?php echo htmlspecialchars($user['profileImage']) ?>">
                            <button name="delete" type="submit" value="delete">Delete</button>
                        </form>

                    </div>

                </div>

            </div>

        </div>
                <div class="profileSettingsEmail">

            <div class="row">

                <div class="col-1"></div>

              

                <div class="col-5 d-flex justify-content-end ">
                    <form action="" method="post" >
                        <label for="editEmail">Change e-mail</label>
                        <input type="email" name="editEmail" id="email"placeholder="<?php echo htmlspecialchars($user['email']) ?>">
                        <input type="submit" value="Update Email" name="submitEmail">
                    </form>
                </div>

                <div class="col-1"></div>


            </div>

        </div>


        <?php include('./nav.inc.php') ?>

    </body>

    </html>


</body>

</html>