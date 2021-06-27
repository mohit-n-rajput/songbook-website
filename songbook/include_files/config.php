<?php
    ob_start();   //start the output buffer
    session_start(); //start the session

    $timezone = date_default_timezone_set("Asia/Kolkata");

    //this is database connection variable. syantax:mysqli_connect("localhost","username","password","database name")
    $con = mysqli_connect("localhost","root","","songbook");

    //mysqli_connect_errno(): it check the database connection error.
    if(mysqli_connect_errno()){
        echo "Failed to connect:".mysqli_connect_errno();
    }
?>
