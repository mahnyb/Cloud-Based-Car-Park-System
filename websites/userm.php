<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("userm.html");
        echo "You are in User Not Done";
    }
    else{
        header("Location: index.php");
    }
    
?>
