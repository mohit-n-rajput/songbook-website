<?php

    include("include_files/includedFile.php");

    if(isset($_GET['id'])) {
        $artistId = $_GET['id'];
    }
    else {
        header("Location: index.php");
    }

    $artist = new Artist($con, $artistId);
?>

<!-- show the artists songs -->
<div class="entityInfo borderBottom">

    <div class="centerSection">

        <div class="artistInfo">

            <h1 class="artistName"><?php echo $artist->getArtistName(); ?></h1>

            <div class="headerButtons">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>

        </div>

    </div>

</div>


<!-- show the artists song list -->
<div class="trackListContainer borderBottom">
        <h2>Trending Songs</h2>
        <ul class="trackList">
            <?php
               $songIdArray = $artist->getSongIdsFromArtists();

               $count = 1;
               foreach ($songIdArray as $songId) {

                    //responsible for show only 5 songs of artist.
                    if($count > 5) {
                        break;
                    }

                    // echo $songId . "<br>";
                    $albumSong = new Song($con, $songId);
                    $albumSongArtist = $albumSong->getSongArtist();

                    /*
                    echo $count."&nbsp;".$albumSong->getSongTitle()."&nbsp;". $albumSong->getSongArtist()->getArtistName()."&nbsp;".$albumSong->getSongGenre(). "&nbsp;"."<br>";
                    echo $albumSong->getSongTitle(). "<br>";
                    */

                    /* we use  'setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)' beacuse in array song id store as 1 : "3" for this string reason we use "". */
                    echo "<li class='trackListRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                                <span class='trackNumber'>$count</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>". $albumSong->getSongTitle() ."
                                </span>

                                <span class='trackArtistName'>". $albumSongArtist->getArtistName() ."
                                </span>
                            </div>

                            <div class='trackOption'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionsButton' src='/songbook/assets/images/icons/3Dots.png' onclick='showOptionsMenu(this)'>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>". $albumSong->getSongDuration()."
                                </span>
                            </div>


                          </li>
                        ";

                    $count++;
               }


            ?>

            <script type="text/javascript">
                //save the id of all song id of all album page
                /* don't use "" quote for json_encode(), generate temp playlsit.*/
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
                console.log("Album playlist" + tempPlaylist);
            </script>
        </ul>
</div>

<!-- code for showing artist's album -->
<div class="gridViewContainer">

    <h2>Albums</h2>
    <?php
        // select all columns
        $albumSelectionQuery = $albumQuery = mysqli_query($con, "SELECT * FROM Albums WHERE artist='$artistId'");

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

<!-- code for options -->
<nav class="optionsMenu">
    <!-- help id about current selceted song. -->
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
