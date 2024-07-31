<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("acmcp.html");
    }
    else{
        header("Location: index.php");
    }
    
?>