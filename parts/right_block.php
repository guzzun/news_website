<div class="right_block"> <!-- right block-->

    
    <div class="related"> <!-- related-->
        <?php
        $sql_related = "SELECT a.id, a.nr_vizionari, a.nume_imagine, a.titlu, a.data_plasarii
        FROM articles a
        INNER JOIN (
            SELECT id, MAX(`nr_vizionari`) nr_vizionari
            FROM articles
            GROUP BY id
        ) b ON a.id = b.id AND a.nr_vizionari = b.nr_vizionari
        Limit 6";

        $results_related = mysqli_query($conn, $sql_related) or die(mysqli_error($conn));

        while ($row = mysqli_fetch_assoc($results_related)) {
            echo '
                <div class="related_block"> <!-- related_block -->
                    <div class="related_img">
                        <a href="article.php?id=' . $row['id'] . '">
                            <img src="img/post/' . $row['nume_imagine'] . '" alt="1+">
                        </a>
                    </div>
                    
                    <div class="related_text">
                        <a href="article.php?id=' . $row['id'] . '"> ' . $row['titlu'] . ' </a>
                        <div class="related_date">
                            <i class="fas fa-clock"></i>
                            <p> ' . $row['data_plasarii'] . ' </p>
                        </div>
                    </div>
                </div> <!-- ./related_block -->
                ';
        }
        ?>
    </div> <!-- ./related -->

    <div class="video"> <!-- video -->
        <?php
            $sql_videos = "SELECT * FROM videos";
            $results_videos = mysqli_query($conn, $sql_videos) or die(mysqli_error($conn));
            while($row = mysqli_fetch_assoc($results_videos)){
                echo '
                <div class="video_info">
                    <div class="video_block">
                        <iframe src="'.$row['src_iframe'].'" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
        
                    <a href="#">
                        '.$row['titlu'].'
                    </a>
                    <p> '.$row['data_plasarii'].' </p>
                </div> <!-- ./video info -->
                ';
            }
        ?>
    </div> <!-- video -->
    
</div> <!-- ./right block -->