<?php

    include("include_files/includedFile.php");

    //get search keyword from url.
    if(isset($_GET['term'])) {
        //decode the url and remove % for space in term on webpage.
        $term = urldecode($_GET['term']);
        /*echo $term;*/
    }
    else {
        $term = "";
    }
?>

<div class="searchContainer">

    <h4>Search here for an artist, album or song</h4>
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..."  spellcheck="false" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
    <!-- this code is so important to start cursor at beginning. onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" -->
</div>

<!--  use async in header.php to load timer. -->
<script>

    /*we give this searchInput  to focus because when user stop typing then it still on page ,this.value = this.value help us to store currnet value on search bar .*/
    $(".searchInput").focus();


    $(function() {

        $(".searchInput").keyup(function() {
             //cancel the timer,every time we type it start timer again.
            clearTimeout(timer);

            /* reset the new time, this line of code is responsible for term show the search result after 2 sec.*/
            timer = setTimeout(function() {

                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
                console.log("term searched.");
            }, 2000);

        });


    });

</script>

<!-- If term string is empty then don't load the page.  -->
<?php if($term == "") exit(); ?>

<!--  show the search term songs. -->
<div class="trackListContainer borderBottom">
        <h2>Trending Songs</h2>
        <ul class="trackList">
            <?php

               /*Means antthing is start or end or containing the search term.*/
               $songsQuery = mysqli_query($con, "SELECT id FROM Songs WHERE title LIKE '$term%' LIMIT 10");

               /* if song not found.*/
               if(mysqli_num_rows($songsQuery) == 0) {
                    echo "<span class='noResults'>No songs found matching with word " . $term . "</span>";
                }


               $songIdArray = array();

               $count = 1;
               while($row = mysqli_fetch_array($songsQuery)) {

                    //responsible for show only 5 songs of artist.
                    if($count > 15) {
                        break;
                    }

                    //push fetch id to the array of songId.
                    array_push($songIdArray, $row['id']);


                    // echo $songId . "<br>";
                    $albumSong = new Song($con, $row['id']);
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

<!--  search for artist -->
<div class="artistsContainer borderBottom">

    <h2>ARTISTS</h2>

    <?php
    $artistsQuery = mysqli_query($con, "SELECT id FROM Artists WHERE name LIKE '$term%' LIMIT 10");

    if(mysqli_num_rows($artistsQuery) == 0) {
        echo "<span class='noResults'>No artists found matching with word " . $term . "</span>";
    }

    while($row = mysqli_fetch_array($artistsQuery)) {

        $artistFound = new Artist($con, $row['id']);

        echo "<div class='searchResultRow'>
                <div class='artistName'>

                    <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getArtistId() ."\")'>
                    "
                    . $artistFound->getArtistName() .
                    "
                    </span>

                </div>

            </div>";

    }


    ?>

</div>

<!--  search for albums -->
<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM Albums WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($albumQuery) == 0) {
            echo "<span class='noResults'>No albums found matching with word " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($albumQuery)) {

            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath'] . "'>

                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                    </span>

                </div>";



        }
    ?>

</div>

<nav class="optionsMenu">
    <!-- help id about current selceted song. -->
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
