<?php
    //session start by config.php
    include("include_files/config.php");
    /* include the artist class, reason we add Artist.php before classes/Album.php,because
        our Album.php class return the Artist object by getAlbumArtistName , if we add Album.php before  Artist.php then it's not find class Artist and give error.
    */
    include("include_files/classes/Artist.php");
    include("include_files/classes/Album.php");
    include("include_files/classes/Song.php");
    include("include_files/classes/User.php");
    include("include_files/classes/Playlist.php");


/*
till now we don't have logout featute for logout manuallu use,session_destroy().
After message shown on index.php,Then session_destroy and page redirct to register.php.
This is temporary after we add logout button we remove it.
*/

// session_destroy();

//validate the session

    if(isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
        $username = $userLoggedIn->getUsername();
        echo "<script>userLoggedIn = '$username';console.log(userLoggedIn);</script>";
    }
    else{
        header("Location: register.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon/s.ico">
        <title>Welcome to Songbook</title>
        <link rel="stylesheet" type="text/css" href="/songbook/assets/css/style.css">



       <!--  <script type="text/javascript" src="/songbook/assets/jQuery/jQuery-min-3.3.1.js"></script>
        -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

      <script type="text/javascript" src="/songbook/assets/js/script.js" async></script>
    </head>
    <body>
         <!-- <script>
            /* if you have more than one folder in htdocs than use /songbook/assets/music/paradise.mp3.
            if you use element which is inside one folder use  assets/music/paradise.mp3
            ,and from out from one folder use ../assets/music/paradise.mp3*/
            console.log('file connected');
            var audioElement = new Audio();
            audioElement.setTrack("/songbook/assets/music/paradise.mp3");
            audioElement.audio.play();
        </script>
        -->
        <!-- this is main webpage Container. -->
        <div class="mainContainer">
            <!-- This topContainer : navigationBarContainer + mainContainer -->
            <div id="topContainer">
                <!-- this section conrain the playingBarContainer -->
                <?php include("include_files/navbarContainer.php");     ?>
                <div id="mainViewContainer">
                    <div id="mainContent">


