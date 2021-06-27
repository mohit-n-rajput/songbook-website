<?php include("include_files/includedFile.php");

if(isset($_GET['id'])) {
    $playlistId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());
?>

<div class="entityInfo">

    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/playlist2.jpeg">
        </div>
    </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <!-- we already style the button for artist page. -->
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>

    </div>

</div>

<!--  showing songs in playlist -->
<div class="trackListContainer">
        <ul class="trackList">
            <?php
               $songIdArray = $playlist->getSongIds();;

               $count = 1;
               foreach ($songIdArray as $songId) {
                    // echo $songId . "<br>";
                    $playlistSong = new Song($con, $songId);
                    $songArtist = $playlistSong->getSongArtist();

                    /*
                    echo $count."&nbsp;".$albumSong->getSongTitle()."&nbsp;". $albumSong->getSongArtist()->getArtistName()."&nbsp;".$albumSong->getSongGenre(). "&nbsp;"."<br>";
                    echo $albumSong->getSongTitle(). "<br>";
                    */

                    /* we use  'setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)' beacuse in array song id store as 1 : "3" for this string reason we use "". */
                    echo "<li class='trackListRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                                <span class='trackNumber'>$count</span>
                            </div>


                            <div class='trackInfo'>
                                <span class='trackName'>" . $playlistSong->getSongTitle() . "</span>
                                <span class='artistName'>" . $songArtist->getArtistName() . "</span>
                            </div>

                            <div class='trackOption'>
                                <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                                <img class='optionsButton' src='/songbook/assets/images/icons/3Dots.png' onclick='showOptionsMenu(this)'>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>" . $playlistSong->getSongDuration() . "</span>
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

<!-- create data about 3 dot option. -->
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
</nav>
