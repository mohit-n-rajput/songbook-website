<?php
/*this file say's that request is sent by ajax or mannualy by user.*/

    /* HTTP_X_REQUESTED_WITH is ajax request,*/
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include("include_files/config.php");
        include("include_files/classes/User.php");
        include("include_files/classes/Artist.php");
        include("include_files/classes/Album.php");
        include("include_files/classes/Song.php");
        include("include_files/classes/Playlist.php");

        if(isset($_GET['userLoggedIn'])) {
            $userLoggedIn = new User($con, $_GET['userLoggedIn']);
        }
         else {
            echo "Username variable was not passed into page. Check the openPage JS function";
            /* if error ,then no page is loaded.*/
            exit();
        }
    }

    //if it's not request by ajax then, below code executed.
    else {
        include("include_files/header.php");
        include("include_files/footer.php");

        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        exit();  //it prevent's to load the rest of part twice.

    }



?>
