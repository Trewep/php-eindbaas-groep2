<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include_once(__DIR__ . "/classes/Security.php");
Security::mustBeLoggedIn(); //not logged in no entry

$id = $_SESSION["userId"];

include_once(__DIR__ . "/classes/User.php");


//(profile)Image upload in directory and name in db
$target_dir = "uploads/";

if (!empty($_POST["submit"])) {

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
}

$error = '';

// Check if image file is a actual image or fake image
if (!empty($_POST["submit"])) {

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
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
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && !empty($_FILES["file"]["name"])
    ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $avatar = basename($_FILES["fileToUpload"]["name"]);
            $user = new User();
            $user->setAvatar($avatar);
            $user->setUserId($_SESSION["userId"]);
            $user->uploadAvatar();
        }
    }
}


//Profile image delete in directory and name in db
if (!empty($_POST['delete'])) {

    if (array_key_exists('delete_avatar', $_POST)) {
        $user = new User();
        $user = $user->setUserId($_SESSION["userId"]);
        $user->deleteAvatar();
    } else {
        $error = 'sorry your profile image has not been deleted please try again';
    }
    if (array_key_exists('delete_avatar', $_POST)) {
        $filename = $_POST['delete_avatar'];
        $file_dir = $target_dir . $filename;
        unlink($file_dir);
    }
}

//haal de gegevens op van de user aan de hand van het sessionId
$user = new User;
$user = $user->setUserId($_SESSION["userId"]);
$user = $user->getUserById();
$u = new User;
$u = $u->setUserId($_SESSION["userId"]);
if (isset($_POST["confirmPrivate"])){
    
    if(!empty($_POST["privatecheck"])){
    $privatecheck = 1;
    $u->setPrivatecheck($privatecheck);
    $u->privateAccount();
    } else {
    $privatecheck = 0;
    $u->setPrivatecheck($privatecheck);
    $u->privateAccount();
    }}

if (!empty($_POST['submitEmail'])) {
    $editEmail = $_POST['editEmail'];
    $editFirstname = $_POST['editFirstname'];
    $editLastname = $_POST['editLastname'];
    $editBio = $_POST['editBio'];
    
    $u = new User;
    $u = $u->setUserId($_SESSION["userId"]);
    
    
    if(!empty($_POST['editPassword'])) {
        if ($u->validatePasswordRequirements($_POST['editPassword'])) {
                $editPassword = $u->bcrypt($_POST['editPassword']);
        }
        $u->updatePassword($id, $editPassword);
        
    }
    $u->setEditEmail($editEmail);
    $u->updateEmail();
    $u->updateFirstname($id, $editFirstname);
    $u->updateLastname($id, $editLastname);
    $u->updateBio($id, $editBio);
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/svg" href="assets/logo/logoIcon/iconDarkRed.svg">
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
        <?php include("./desktopnav.inc.php")?>

        <!-- als er eem error is bij het uploaden van de avatar toon deze -->
        <?php if (isset($error)) : ?>
            <div class='row'>
                <div class="col-1"></div>
                <div class="col-10 d-flex justify-content-center error">
                    <?php echo $error ?>
                </div>
                <div class="col-1"></div>
            </div>
        <?php endif; ?>

        <div class="profileSettingsImage cardView">
                <div class="profileImage">
                    <!-- check of de profielfoto van de eigenaar van het profiel gelijk is aan de defaultavatar of niet. Als het wels is wordt deze geprint anders de foto die in de db zit -->
                    <?php if ($user['profileImage'] === 'defaultAvatar') : ?>
                        <img src="./assets/images/defaultAvatar.png" alt="">
                    <?php else : ?>
                        <img src="./uploads/<?php echo htmlspecialchars($user['profileImage']) ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="fileToUpload" class="profileSettingsLabel">Change profile picture</label>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit" id="profileUpload">
                    </form>
                </div>
                    
                        <form action="" method="post">
                            <div class="settingsField" id="settingsFieldDelete">
                            <label for="deleteAvatar" class="profileSettingsLabel"> Delete profile picture</label>
                            <input type="hidden" name="delete_avatar" value="<?php echo htmlspecialchars($user['profileImage']) ?>">
                            </div>
                            <input name="delete" type="submit" value="Delete" id="deleteProfilePicture">
                        </form>
                    
        </div>
        <div class="profileSettingsEmail cardView">
            <form action="" method="post">
                <div class="settingsField">
                    <label for="editBio" class="profileSettingsLabel">Change bio</label>
                    <textarea type="text" name="editBio" id="editBio" placeholder="<?php echo htmlspecialchars($user['bio']) ?>"><?php echo htmlspecialchars($user['bio']) ?></textarea>
                </div>
                <div class="settingsField">
                    <label for="editFirstname" class="profileSettingsLabel">Change first name</label>
                    <input type="text" name="editFirstname" id="editFirstname" value="<?php echo htmlspecialchars($user['firstname']) ?>" placeholder="<?php echo htmlspecialchars($user['firstname']) ?>">
                </div>
                <div class="settingsField">
                    <label for="editLastname" class="profileSettingsLabel">Change last name</label>
                    <input type="text" name="editLastname" id="editLastname" value="<?php echo htmlspecialchars($user['lastname']) ?>" placeholder="<?php echo htmlspecialchars($user['lastname']) ?>">
                </div>
                <div class="settingsField">
                    <label for="editEmail" class="profileSettingsLabel">Change e-mail</label>
                    <input type="email" name="editEmail" id="email" value="<?php echo htmlspecialchars($user['email']) ?>" value="<?php echo htmlspecialchars($user['email']) ?>">
                </div>
                <div class="settingsField">
                    <label for="editPassword" class="profileSettingsLabel">Change password</label>
                    <input type="text" name="editPassword" id="editPassword" placeholder="New password">
                </div>
                
                <?php if (isset($error)) : ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
                
                <input type="submit" value="Update settings" name="submitEmail">
            </form>
        </div>
        <div class="profileSettingsPrivate cardView">
            <?php if($user['privateAccount'] ==1): ?>
                <form action="" method="post" >
                    <div class="settingsFieldAlt">
                        <label for="privatecheck" class="profileSettingsLabel" id="spaceFix">Private account?</label>
                        <input type="checkbox" name="privatecheck" id="privatecheck"checked>
                    </div>
                    <input type="submit" value="Confirm private" name="confirmPrivate">
                    
                </form>
                <?php elseif($user['privateAccount'] ==0): ?>
                <form action="" method="post" >
                    <div class="settingsFieldAlt">
                        <label for="privatecheck" class="profileSettingsLabel" id="spaceFix">Private account?</label>
                        <input type="checkbox" name="privatecheck" id="privatecheck">
                    </div>
                    <input type="submit" value="Confirm private" name="confirmPrivate">
                </form>
                <?php endif ?>
                <a href="logout.php" id="profileLogout">Log out</a>
        </div>
        
        
        
        

        <?php include('./nav.inc.php') ?>
        <?php include('./desktopfooter.inc.php') ?>


    </body>

    </html>


</body>

</html>