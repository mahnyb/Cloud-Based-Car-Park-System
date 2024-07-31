<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("myaccount.html");
        echo "You are in My Account Not Done";
    }
    else{
        header("Location: index.php");
    }
    
?>