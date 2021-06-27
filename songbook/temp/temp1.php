// nowPlayingBarContainer code.
<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="assets/images/albums/divide-edshreen.jpeg" class="albumImage">
                </span>
                <div class="trackInfo">
                    <span class="trackName">Shape of you</span>
                    <span class="artistName">Ed Sheeran</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
                    <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous button" onclick="prevSong()">
                    <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play button" onclick="playSong()">
                    <img src="assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                    <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next button" onclick="nextSong()">
                    <img src="assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
                    <img src="assets/images/icons/repeat.png" alt="Repeat">
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
                <button class="controlButton volume" title="Volume Button">
                <img src="assets/images/icons/volume.png" alt="volume">
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


//2 navBarContainer Code.
<div id="navBarContainer">
    <nav class="navBar">
        <a href="index.php" class="logo">
            <img src="assets/images/icons/avatar.png" alt="profile">
        </a>
        <div class="group">
            <div class="navItem">
                <a href="search.php" class="navItemLink">Search
                    <img src="assets/images/icons/search.png" class="icon" alt="search">
                </a>
            </div>
        </div>
        <div class="group">
            <div class="navItem">
                <a href="browse.php" class="navItemLink">Browse</a>
            </div>
            <div class="navItem">
                <a href="yourMusic.php.php" class="navItemLink">Your Music</a>
            </div>
            <div class="navItem">
                <a href="user.php" class="navItemLink">Profile</a>
            </div>
        </div>
    </nav>
</div>
