<?php

    include("include_files/includedFile.php");
    /*include("include_files/header.php"); ,beacuse for request header.php called twice.*/
?>
    <!--  browse page is index page. -->

    <!-- till this is header part -->

    <!-- content -->
    <h1 class="pageHeadingBig">You might also like</h1>

    <div class="gridViewContainer">
        <?php
            // select all columns
            $albumSelectionQuery = mysqli_query($con, "SELECT * FROM Albums ORDER BY RAND() LIMIT 25");
            while($row = mysqli_fetch_array($albumSelectionQuery)){

            /* in album we fetch the title array.,we write html in php only between " " , our div is created many times till loop terminates.*/

                /*  tabindex=0 means if user press tab then it will not goes on other nav items. , <span role='link' tabindex='0' onclick="openPage('search.php')" class="navItemLink"> is called Dynamic Link. */
                echo "<div class='gridViewItem'>
                        <span class='gridNoOutline' role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath'] . "'>

                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                        </span>
                      </div>";
            }
        ?>
    </div>


<!-- this is footer, so we dont' need footer.php here because nowPlayingBar.php have it, so we have control out nowPlayingBar -->
<!-- ?php include("include_files/footer.php");   ?> -->
