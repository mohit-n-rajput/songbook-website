<!-- add all header and footer part for main Container Part -->
<?php
    include("include_files/includedFile.php");
    /*include("include_files/header.php"); ,beacuse for request header.php called twice.*/

    if(isset($_GET['id'])){
        $albumId = $_GET['id'];
    }
    else {
        header("Location: index.php");
    }

    /*
    if we want to call Artist and album class  method then we create the object of the class Artist
    */

    $album = new Album($con, $albumId);
    $artist = $album->getAlbumArtistName();
    /*
        echo "Album title is: " .$album->getAlbumTitle() ."<br>";
        echo "Artist name is: " . $artist->getArtistName();
    */
?>
    <!-- till this is header part -->
    <div class="entityInfo">
        <div class="leftSection">
            <img src="<?php echo $album->getAlbumArtworkPath();?>">
        </div>

         <!-- IF you want to put text on website span is bit of good option. -->
        <div class="rightSection">
            <h2><?php echo $album->getAlbumTitle();?></h2>
            <p>By <?php echo $artist->getArtistName();?> </p>

            <p><?php echo $album->getNumberOfSongsFromAlbums(); ?> Songs</p>
        </div>
    </div>

    <div class="trackListContainer">
        <ul class="trackList">
            <?php
               $songIdArray = $album->getSongIdsFromAlbums();

               $count = 1;
               foreach ($songIdArray as $songId) {
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
                /* don't use "" quote for json_encode()*/
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
                console.log("Album playlist" + tempPlaylist);
            </script>
        </ul>
    </div>

  <!-- this is footer, so we dont' need footer.php here because nowPlayingBar.php have it, so we have control out nowPlayingBar -->
<!-- ?php include("include_files/footer.php");   ?> -->

<nav class="optionsMenu">
    <!-- help id about current selceted song. -->
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>

<!--  <input type='hidden' class='songId' value='" . $albumSong->getId() . "'> is help us to find which song is we added to playlist. -->
