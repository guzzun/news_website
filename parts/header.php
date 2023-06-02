<header id="header"> <!-- header -->

    <div class="container">
        <div class="header_inner">
            

            <div class="social">
                <div class="social_block" >
                    <a href="#"> facebook </a>
                    <a href="#"> instagram </a>
                    <a href="#"> telegram </a>
                </div>

                <div class="social_block">
                    <a href="#"> linkedIn </a>
                    <a href="#"> youtube </a>
                    <a href="#"> twitter </a>
                </div>   

                <div class="menu_header">
                    <i onclick="openMenu()" class="fas fa-bars"></i>
                </div>

            </div>


            <div class="name">
                <a href="index.php"> gudnews </a>
            </div>

            
            <div class="login">
                <?php 
                    if(isset($_SESSION['Email'])){
                        echo '
                        <div class="login_block1">
                            <a href="#"> <i class="fas fa-user-circle"></i> </a>
                            <a href="user_exit_from_acc.php"> <i class="fas fa-sign-out-alt"></i> </a>
                        </div>
                        ';
                    } else {
                        echo '

                            <div class="login_block2">
                                <a href="login.php"> log in </a>
                                <a href="register.php"> register </a>
                            </div>                        
                        ';
                    }
                ?>
            </div>


        </div> <!-- ./header inner -->
    </div>

</header> <!-- header end -->