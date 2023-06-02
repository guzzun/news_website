<?php
session_start();
include "database/connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/31688d0a64.js" crossorigin="anonymous"></script>
    <title> GUDNEWS </title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="img/logo.svg">
    <!-- <script src="js/script.js"></script> -->
</head>

<body>

    <form class="auth" action="" method="post">
        <div class="auth_header">
            <a href="index.php"> <img src="img/logo.svg" alt="logo"> </a>
            <a href="index.php"> <i class="close_btn fas fa-times"></i> </a>
        </div>


        <div class="auth_inner">
            <input type="text" placeholder="Your Email" name="login" id="email" required>
            <input type="password" placeholder="Password" name="password" id="psw" required>
            <button type="submit" name="submit" class="register_btn"> Login</button>
        </div>

        <div class="auth_footer">
            <p> Don't have an account? <a href="register.php"> Register. </a></p>
        </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE user_email = '$login' AND user_passwd = '$password'";
        $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $results = mysqli_fetch_assoc($results);
        if (!empty($results)) {
            if($results['role'] == 1)
                echo '<script>window.location.href = "atmin/crud.php";</script>';
            else{
                $_SESSION['Email'] = $results['user_email'];
                echo '<script>window.location.href = "index.php";</script>';
            }
        } else
            echo '<script>alert("este!");</script>';
    }
    mysqli_close($conn);
    ?>
</body>

</html>