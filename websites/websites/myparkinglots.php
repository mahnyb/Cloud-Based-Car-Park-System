<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("myparkinglots.html");
        echo "You are in My Parking Lots Not Done";
    }
    else{
        header("Location: index.php");
    }
    
?>