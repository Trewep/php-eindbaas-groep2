<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once(__DIR__ . "/classes/Security.php");
Security::mustBeLoggedIn();

$id =$_SESSION["userId"];


include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/functions.php");


$user = User::getUserById($_SESSION["userId"]);

if(!empty($_POST ["editEmail"])){
$editEmail = $_POST['editEmail'];
$u = new User;
$u->updateEmail($id, $editEmail);
}
if(!empty($_POST ["privatecheck"])){
    $privatecheck = $_POST['privatecheck'];
    $u = new User;
    $u->privateAccount($id, $privatecheck);
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
                <div class="col-5 d-flex justify-content-end ">
                <?php var_dump($user['private'])?>
                <?php if($user['private'] ==1): ?>
                    <form action="" method="post" >
                        <label for="privatecheck">Private account?</label>
                        <input type="checkbox" name="privatecheck" id="privatecheck"checked>
                        <input type="submit" value="Confirm private" name="confirmPrivate">
                    </form>
                    <?php endif ?>
                    <?php if($user['private'] ==0): ?>
                    <form action="" method="post" >
                        <label for="privatecheck">Private account?</label>
                        <input type="checkbox" name="privatecheck" id="privatecheck">
                        <input type="submit" value="Confirm private" name="confirmPrivate">
                    </form>
                    <?php endif ?>
                </div>

                <div class="col-1"></div>


            </div>

        </div>


        <?php include('./nav.inc.php') ?>

    </body>

    </html>


</body>

</html>