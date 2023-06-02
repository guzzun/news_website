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
            <input type="text" placeholder="Email" name="email" id="email" required>
            <input type="password" placeholder="Password" name="psw" id="psw" required>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
            <button type="submit" name="submit" class="register_btn"> Register </button>
        </div>

        <div class="auth_footer">
            <p> Already have an account? <a href="login.php">Login</a>.</p>
        </div>
    </form>
    <?php
    include "database/connect.php";
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $psw = $_POST['psw'];
            $psw_repeat = $_POST['psw-repeat'];

            if ($psw == $psw_repeat) {
                $insert_new_user = "INSERT INTO users(role,user_email,user_passwd)
                                        VALUES(0,'$email','$psw')";
                if (mysqli_query($conn, $insert_new_user)){
                    session_start();
                    $_SESSION['Email'] = $email;
                    echo '<script>window.location.href = "index.php";</script>';
                }
                else
                    echo '<script>alert("Error:' . $query . '<br>' . mysqli_error($conn) . '");</script>"';
            } else
                echo "<script>alert('passwords do not match');</script>";
        }
    mysqli_close($conn);
    ?>
</body>

</html>