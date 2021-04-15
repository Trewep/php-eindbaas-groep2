<?php
session_start();
include_once(__DIR__ . "/classes/User.php");

if (!empty($_POST["username"]) && !empty($_POST["password"])) {

    //formulier verzonden
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {

        User::getUserByUsername($username, $password);

        $_SESSION["username"] = $username;
        $_SESSION["userId"] = $userId;

        //user id toevoegen?? vragen aan Nick

    } catch (\Throwable $th) {

        $error = $th->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" type="image/svg" href="assets/logo/logoIcon/iconDarkRed.svg">
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!--overriding DEBUFF css-->
    <link rel="stylesheet" href="css/debuffStyle.css">
    <!--design pagina: https://www.figma.com/proto/jzjm99ggCTUSNv7ITLuLZl/PHP-project-DEBUFF?node-id=3%3A147&viewport=444%2C-1081%2C0.47289735078811646&scaling=scale-down-->
</head>

<body class="loginPage">
    <header>
        <a href="index.php"><img src="assets/logo/logoFull/fullDarkRed.svg" alt="Logo Debuff" class="logo"></a>
    </header>
    <section class="loginScreen">
        <h1 class="loginHeading">LOGIN</h1>
        <div class="login">
            <form action="" method="POST" class="loginForm">
                <label for="username">e-mail or username</label>
                <input type="text" class="loginInput" id="username" name="username" placeholder="hello@debuff.com">
                <label for="password">password</label>
                <input type="password" name="password" id="password" class="loginInput" placeholder="********">
                <!--nog toevoegen forgot password?-->
                <label for="login"></label>
                <input type="submit" value="Login" name="login" id="login" class="loginBtn">
            </form>
        </div>
        <?php if (isset($error)) : ?>
            <div class="errorLogin">
                <div class="errorMessageLogin">
                    <p><?php echo $error; ?></p>
                    <a href="">forgot password?</a>
                </div>
            <?php endif; ?>
            </div>
            <div class="loginToRegister">
                <p class="AlreadyAccount">Don't have an account yet?</p>
                <button class="btnAlreadyAccount"> <a href="register.php">Register</a></button>
            </div>
    </section>
</body>
</html>