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
    <title> GUDNEWS </title>
        <script src="https://kit.fontawesome.com/31688d0a64.js" crossorigin="anonymous"></script>
        <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet"> -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="img/logo.svg">
        <script src="js/script.js"></script>
 
        <!-- php -->
        <?php
            $id_article = $_GET['id'];
            $sql = "SELECT * FROM articles WHERE id = $id_article";
            $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $results = mysqli_fetch_assoc($results);

            //increment number of articles views
            $current_views = mysqli_query($conn, "SELECT nr_vizionari FROM articles WHERE id = $id_article");
            $current_views = mysqli_fetch_row($current_views);
            $current_views = $current_views[0]+1;
            
            $update_nr_views = "UPDATE articles SET nr_vizionari = $current_views WHERE id = $id_article";
            mysqli_query($conn, $update_nr_views) or die("Error on update number of views: ".mysqli_error($conn));
        ?>
</head>
<body>
    
    <?php include "parts/sidebar.php" ?>

    <div class="page"> <!-- page -->

        <?php include "parts/sidemenu.php" ?> <!-- sidemenu -->
        <!-- header -->
        <?php include "parts/header.php" ?>


        <!-- search bar -->
        <div class="container"> 
            <div class="search_bar">
                <form action="search.php" method="POST">
                    <input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div> <!-- ./search bar -->
   

    
    <div class="content"> <!-- content -->
        <div class="container">
            <div class="content_inner">

                <!-- block title -->
                <div class="block_title"> 
                    <div class="block_1"> <h3> News </h3> </div>
                    <div class="block_2"> <h3> Related articles </h3> </div>
                </div>
                
                <div class="news"> <!-- news -->
                    <div class="post"> <!-- post -->

                        <div class="post_block"> <!-- post block -->
                            <div class="post_actions">
                                <div class="post_back">
                                    <a href="index.php"> <i class="fas fa-long-arrow-alt-left"></i> </a>
                                </div>

                                <div class="post_share">
                                    <a href="#"> share </a>
                                    <a href="#"> <i class="fas fa-share-alt"></i> </a>
                                </div>
                            </div>
                            
                            <!-- title -->
                            <h2 class="post_title post_title--open">
                                <?php echo $results['titlu']; ?>
                            </h2>

                            <!-- post_footer -->
                            <div class="post_footer post_footer--open">
                                <ul class="post_data">
                                    <li class="post_data-item">
                                        <time datetime="14-06-2021 12:12"> <?php echo $results['data_plasarii']; ?> </time>
                                    </li>
                                    <li class="post_data-item">
                                        <a href="#"> <?php echo $results['categorie']; ?> </a>
                                    </li>
                                </ul>

                                <div class="post_click">
                                    <div class="post_views">
                                        <i class="fas fa-eye"></i>
                                        <p> <?php echo $results['nr_vizionari']; ?> </p>
                                    </div>

                                    <div class="post_comment">
                                        <i class="fas fa-comments"></i>
                                        <a href="#comment"> comments </a>
                                    </div>
                                </div>

                            </div> <!-- ./post_footer -->

                            <div class="post_img--open">
                                <img src="img/post/<?php echo $results['nume_imagine']; ?>" alt="">
                            </div>

                            <div class="post_text">
                                <?php echo $results['continutu']; ?>
                            </div>
                          
                            <h4 id="comment" class="comment_header" > Comments </h4>
                            <form action="" method="POST" class="comments">
                                <?php
                                    $select_coments = "SELECT comment,user_email FROM articles_comments WHERE id_article = $id_article";
                                    $coments_results = mysqli_query($conn, $select_coments);

                                    if(isset($_SESSION['Email'])){
                                        echo '
                                        <br>
                                        <textarea name="user_comment" class="user_comment" placeholder="Type"></textarea>
                                        <br>
                                        <input class="comment_btn" type="submit" name="submit" value="Send">                                        
                                        ';
                                    }

                                    if(mysqli_num_rows($coments_results) > 0){
                                        while($row = mysqli_fetch_assoc($coments_results)){
                                            echo '
                                            <div class="comment_block">
                                                <h3>'.substr($row['user_email'], 0, strpos($row['user_email'], "@")).'</h3>
                                                <p>'.$row['comment'].'</p>
                                                <br>
                                            </div>
                                            ';
                                        }
                                    } else {
                                        echo "<p> No comments </p>";
                                    }

                                    if(isset($_POST['submit'])){
                                        $email = $_SESSION['Email'];
                                        $user_comment = $_POST['user_comment'];
                                        $query = "INSERT INTO articles_comments(id_article,user_email,comment)
                                                  VALUES($id_article,'$email','$user_comment')";
                                        if(mysqli_query($conn, $query))
                                            echo '<script>window.location.href = "article.php?id='.$id_article.'";</script>';
                                        else
                                            echo '<script>alert("Comment erorr!");</script>';
                                    }
                                ?>
                            </form>

                        </div> <!-- ./post block -->
  
                    </div> <!-- ./post -->

                    <?php include "parts/right_block_article.php" ?> <!-- right block -->

                </div> <!-- ./news -->
                        
            </div> <!-- ./content_inner -->

        </div> <!-- ./container -->
    </div> <!-- ./content end -->

    <!-- footer -->
    <?php include "parts/footer.php" ?>
   
    </div> <!-- ./page-->
    
 

</body>
</html>


