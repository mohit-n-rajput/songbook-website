<?php

    /* sometime our javascript and browser are cached in browser, if you run some imp feauture it is better to clear cache and reload the browser.*/
    $playListQuery = mysqli_query($con, "SELECT id FROM Songs ORDER BY RAND() LIMIT 20");
    $resultArray = array();  //this store playlist

    while($row= mysqli_fetch_array($playListQuery)){
        array_push($resultArray, $row['id']);
    }

   $jsonArray = json_encode($resultArray); //php method for convert in json.

?>

<script type="text/javascript">

    $(document).ready(function(){

        var newPlaylist = <?php echo $jsonArray;?>;
        console.log(newPlaylist);
        console.log("Playlist Songs: " + newPlaylist);

        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);

        /* update the full volume at start , here we write audioElement.audio because updateVolumeProgressBar() is the event of audio object of Object class. */
        updateVolumeProgressBar(audioElement.audio);

        /* when we move volume pregressBar other button are highlightes to prevent this,
            on("mousedown touchstart mousemove touchmove",func()) is same mousedown(),mousemove(),etc.. on() mthod's  work is apply all other method tp the same function.
        */
        $('#nowPlayingBarContainer').on("mousedown touchstart mousemove touchmove",function(e){
                /*It prevent's any element's default behaviour. like this apply on a hyperlink then then link not show it's behaviour.*/
                e.preventDefault();
        });

        //  to change the progressBarm mouseUp = mouse clicked , mouseDown = mouse released.
        $(".playbackBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e){
            /* Here e is event object and this is a jquery object which is coversion of ".playbackBar .progressBar" html element. SO  this = ".playbackBar .progressBar" */
            if(mouseDown == true){
                timeFromOffset(e,this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function(e){
            /* Here e is event object and this is a jquery object which is coversion of ".playbackBar .progressBar" html element. SO  this = ".playbackBar .progressBar" */
                timeFromOffset(e,this);
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });


        //Change for volumeBar
        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e){
         /* Here e is event object and this is a jquery object which is coversion of ".volumeBar .progressBar" html element. SO  this = ".volumeBar .progressBar"*/
            if(mouseDown == true){
                var percentage = (e.offsetX) / $(this).width();
                if(percentage >=0 && percentage<=1){
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function(e){
             /* Here e is event object and this is a jquery object which is coversion of ".volumeBar .progressBar" html element. SO  this = ".volumeBar .progressBar" */
                var percentage = (e.offsetX) / $(this).width();
                audioElement.audio.volume = percentage;
         });

    });

    //moving song time in playing bar function.
    function timeFromOffset(mouseEvent, progressBar){
        /* Here e is event object and this is a jquery object which is coversion of ".playbackBar .progressBar" html element. SO  this = ".playbackBar .progressBar" */

       /* calculate the percentage of prograssBar offset, $(this).width()) calculate width whrere we clicked.*/
        var percentage = mouseEvent.offsetX/$(progressBar).width() * 100;
        /* update the time duration*/
        var seconds = (audioElement.audio.duration) * (percentage/100);
        audioElement.setTime(seconds);

    }

    //  previous Song function
    function prevSong() {
        /*if current songs second is >=3 or it is first in playlist then it can't go back.*/
        if(/*audioElement.audio.currentTime >= 3 ||*/ currentIndex == 0) {
            audioElement.setTime(0);
        }
        else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    //  nextSong function
    function nextSong() {

        //repeat function
        if(repeat == true){
            audioElement.setTime(0);
            console.log("song is paused.");
            playSong();
            return;
        }

        console.log("song is played");
        if(currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        }
        else {
            currentIndex++;
        }

        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);

    }

    //repeat song funtion()
    function setRepeat(){
        repeat = ! repeat;  //repeat true
        var imageName =  repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);

    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

        /* playlist info */
        console.log("CurrentPlaylist Songs: " + currentPlaylist);
        console.log("ShufflePlaylist Songs: " + shufflePlaylist);


        if(shuffle == true) {
        //Randomize playlist
            shuffleSongs(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        }

        else {
            //shuffle has been deactivated
            //go back to regular playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }

    }
    //function for shuffle album playlist.
    function shuffleSongs(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    //mute the song function
    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }


    // set track function
     function setTrack(trackId, newPlaylist, play) {

        /* check for shuffling new playlist, Intially first newPlaylist passed , after that it will assign currentPlayList variable and then shuffle set.    */
        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice(); /*create the copy of current playList not original*/

            shuffleSongs(shufflePlaylist);
        }

       /*but is shuffle is true then it will effect only current album playlist not all songs playlist.*/
        if(shuffle == true){
            currentIndex = shufflePlaylist.indexOf(trackId);
        }

        else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }

        pauseSong();

      //get the songs data
      $.post("/songbook/include_files/form_handlers/ajax/getSongsJson.php",{songId: trackId}, function(songsData) {


            var track = JSON.parse(songsData);

            //track Info
            console.log(track);
            console.log(track.title);

            // for present trackname at left in player
            $(".trackName span").text(track.title);


            // for present artistname at left in player by doing ajax call.

            $.post("/songbook/include_files/form_handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(artistData){

                //artist Info
                var artist = JSON.parse(artistData);
                console.log(artist)
                console.log(artist.name);

                // for present artistname at left in player
                $(".trackInfo .artistName span").text(artist.name);

                //activate the artist name link.
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");

            });

            //ajax call for albumArtWork.
            $.post("/songbook/include_files/form_handlers/ajax/getAlbumArtworkJson.php", { albumId: track.album }, function(artWorkData){

                var albumArtwork = JSON.parse(artWorkData);
                console.log(albumArtwork)
                console.log(albumArtwork.artworkPath);

                // for present artistname at left in player
                $(".content .albumLink img").attr("src",albumArtwork.artworkPath);

                //activate the album artwork link.
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + albumArtwork.id + "')");

                //attach the song name with album.
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + albumArtwork.id + "')");

            });

            /* since we pass track which is json object , so need to src.*/

            audioElement.setTrack(track);
            if(play == true){
                playSong(); //keep updated the play button functionality.
            }

        });

    }

    // pause Song() function
    function playSong(){

        if(audioElement.audio.currentTime == 0){
            console.log('plays count updated.');
            //for update count , we  need Ajax call.
            $.post("/songbook/include_files/form_handlers/ajax/updatePlaysJson.php", {songId : audioElement.currentlyPlaying.id});

        }
        // jquery code
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    // pause Song() function
    function pauseSong(){
        //jquery code
        $(".controlButton.pause").hide();
        $(".controlButton.play").show();
        audioElement.pause();
    }



</script>

<!-- this section conrain the playingBarContainer -->
<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <!--  we give this text as span  as role:link to get help with ajax call. -->
                <span class="albumLink">
                    <img role="link" tabindex="0" src="" class="albumImage">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>
                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <!-- playing bar -->
            <div class="content playerControls">
                <div class="buttons">
                    <!-- shuffle button -->
                    <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
                    <img src="/songbook/assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <!-- Previous button -->
                    <button class="controlButton previous" title="Previous button" onclick="prevSong()">
                    <img src="/songbook/assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <!-- Play button -->
                    <button class="controlButton play" title="Play button" onclick="playSong()">
                    <img src="/songbook/assets/images/icons/play.png" alt="Play">
                    </button>
                    <!-- Pause button -->
                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                    <img src="/songbook/assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <!-- Next button -->
                    <button class="controlButton next" title="Next button" onclick="nextSong()" >
                    <img src="/songbook/assets/images/icons/next.png" alt="Next">
                    </button>
                    <!-- Repeat button -->
                    <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
                    <img src="/songbook/assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>
                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>


                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume Button" onclick="setMute()">
                <img src="/songbook/assets/images/icons/volume.png" alt="volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
