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
    <script src="js/app.js"></script>
</head>

<body>
    <!-- sidebar -->
    <?php include "parts/sidebar.php"; ?>

    <!-- page -->
    <div class="page">

        <?php
            include "parts/sidemenu.php"; 
            include "parts/header.php";
        //=== PAGINATION ==============
        $total_records_per_page = 3;

        if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }

        $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM articles");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];

        $offset = ($page_no - 1) * $total_records_per_page;
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";

        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;
        ?>


        <!-- search bar -->
        <div class="container">
            <div class="search_bar">
                <form action="search.php" method="POST">
                    <input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div> <!-- ./search bar -->



        <div id="content" class="content">
            <!-- content -->
            <div class="container">
                <div class="content_inner">

                    <div class="content_header">
                        <!-- Send your news -->

                        <!-- <form action="" method="POST" class="news_nav">
                            <button id="startrunning" type="submit" name="new" style="background: none; border: none; color: white; cursor: pointer;"> new </button>
                            <span> / </span>
                            <button type="submit" name="trending" style="background: none; border: none; color: white; cursor: pointer;"> trending </button>
                        </form> -->

                        <div class="news_nav">
                            <a href="#"> new </a> <span> / </span>
                            <a href="#"> trending </a> 
                        </div>


                        <div class="send_news">
                            <a href="#"> <p> Send your news </p>  </a>
                            <i class="fas fa-envelope"></i>
                        </div>

                    </div> <!-- ./Send your news -->

                    <div class="top_news">
                        <!-- top_news -->
                        <?php
                        $sql = "SELECT id,nume_imagine,titlu,data_plasarii, MAX(`nr_vizionari`) 
                                FROM articles
                                GROUP BY id
                                LIMIT 2";
                        // $sql = "SELECT MAX(nr_vizionari), nume_imagine, titlu, data_plasarii
                        //                                     FROM articles Limit 2";
                        $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        while ($row = mysqli_fetch_assoc($results))
                            echo '
                            <div class="top_item">
                                <div class="top_img">
                                    <a href="article.php?id=' . $row['id'] . '"> <img src="img/post/' . $row['nume_imagine'] . '" alt="pixel5"> </a>
                                </div>
    
                                <div class="top_text">
                                    <h2 class="title"> ' . $row['titlu'] . '. </h2>
                                    <div class="meta">
                                        <i class="fas fa-clock"></i>
                                        <p> ' . $row['data_plasarii'] . ' </p>
                                    </div>
                                </div>
                            </div> <!-- ./top item -->
                            ';
                        ?>
                    </div> <!-- ./top_news -->

                    <div class="news_category">
                        <!-- news category -->
                        <a onclick="sort_post_blocks_display_all()"> all </a> <span> / </span>
                        <a onclick="sort_post_blocks('reviews')"> reviews </a> <span> / </span>
                        <a onclick="sort_post_blocks('movie')"> movie </a> <span> / </span>
                        <a onclick="sort_post_blocks('games')"> games </a> <span> / </span>
                        <a onclick="sort_post_blocks('tech')"> tech </a> <span> / </span>
                        <a onclick="sort_post_blocks('web')"> web </a>
                    </div> <!-- ./news category -->


                    <!-- block title -->
                    <div class="block_title">
                        <div class="block_1">
                            <h3> News </h3>
                        </div>
                        <div class="block_2">
                            <h3> Trending </h3>
                        </div>
                    </div>

                    <div class="news">
                        <!-- news -->
                        <div class="post">
                            <!-- post -->

                            <?php
                            $articles = mysqli_query($conn, "SELECT * FROM articles LIMIT $offset, $total_records_per_page") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_assoc($articles)) {
                                echo '
                                <div blockType="' . $row['categorie'] . '" class="post_block"> <!-- post block -->
                                    <div class="post_header">
                                        <div class="post_img">
                                            <a href="article.php?id=' . $row['id'] . '">
                                                <img src="img/post/' . $row['nume_imagine'] . '" alt="' . $row['nume_imagine'] . '">
                                            </a>
                                        </div>
                                    </div>
        
                                    <div class="post_content">
                                        <h2 class="post_title">
                                            <a href="article.php?id=' . $row['id'] . '"> ' . $row['titlu'] . '. </a>
                                        </h2>
                                        <p class=".post_text">
                                            ' . $row['descrierea'] . '
                                        </p>
                                    </div>
        
                                    <div class="post_footer">

                                        <ul class="post_data">
                                            <li class="post_data-item">
                                                <time datetime="14-06-2021 12:12"> ' . $row['data_plasarii'] . ' </time>
                                            </li>
                                            <li class="post_data-item">
                                                <a href="#">' . $row['categorie'] . '</a>
                                            </li>
                                        </ul>

                                        <div class="post_click">

                                            <div class="post_views">
                                                <i class="fas fa-eye"></i>
                                                <a href="#"> ' . $row['nr_vizionari'] . ' </a>
                                            </div>

                                            <div class="post_comment">
                                                <i class="fas fa-comments"></i>
                                                <a href="article.php?id=' . $row['id'] . '#comment"> comments </a>
                                            </div>
                                        </div>

                                    </div>
        
                                </div> <!-- ./post block -->
                                ';
                            }
                            ?>
                        </div> <!-- ./post -->

                        <!-- right_block -->
                        <?php include "parts/right_block.php"; ?>
                        
                    </div> <!-- ./news -->

                </div> <!-- ./content_inner -->

                <ul class="pagenav"> <!-- pagination -->

                    <?php 
                        if($page_no > 1){ echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=1'>first</a></li>"; } 
                    ?>

                    <li class="pagenav_item <?php if ($page_no <= 1) {
                                                echo "disabled";
                                            } ?>">
                        <a class="pagenav_link" <?php if ($page_no > 1) {
                                                    echo "href='?page_no=$previous_page'";
                                            } ?>>&lt</a>
                    </li>

                    <?php
                    if ($total_no_of_pages <= 10) {
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                            if ($counter == $page_no) {
                                echo "<li class='active pagenav_item'><a class='pagenav_link'>$counter</a></li>";
                            } else {
                                echo "<li><a class='pagenav_link' href='?page_no=$counter'>$counter</a></li>";
                            }
                        }
                    } elseif ($total_no_of_pages > 10) {

                        if ($page_no <= 4) {
                            for ($counter = 1; $counter < 8; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='active pagenav_item'><a class='pagenav_link'>$counter</a></li>";
                                } else {
                                    echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                            echo "<li class='pagenav_item'><a class='pagenav_link'>...</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                        } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=1'>1</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=2'>2</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link'>...</a></li>";
                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='active pagenav_item'><a class='pagenav_link'>$counter</a></li>";
                                } else {
                                    echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                            echo "<li class='pagenav_item'><a class='pagenav_link'>...</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                        } else {
                            echo "<li pagenav_item><a class='pagenav_link' href='?page_no=1'>1</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=2'>2</a></li>";
                            echo "<li class='pagenav_item'><a class='pagenav_link'>...</a></li>";

                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='active'><a class='pagenav_link'>$counter</a></li>";
                                } else {
                                    echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                        }
                    }
                    ?>

                    <li class="pagenav_item <?php if ($page_no >= $total_no_of_pages) {
                                                echo "disabled";
                                            } ?>">
                        <a class="pagenav_link" <?php if ($page_no < $total_no_of_pages) {
                                                    echo "href='?page_no=$next_page'";
                                                } ?>>&gt</a>
                    </li>
                    <?php if ($page_no < $total_no_of_pages) {
                        echo "<li class='pagenav_item'><a class='pagenav_link' href='?page_no=$total_no_of_pages'>last</a></li>";
                    } ?>
                </ul><!-- ./pagination -->

            </div> <!-- ./container -->
        </div> <!-- ./content end -->

        <!-- footer -->
        <?php include "parts/footer.php"; ?>

    </div> <!-- ./page-->
</body>

</html>