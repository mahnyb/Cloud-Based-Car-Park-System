<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("Aacmcp.html");
    }
    else{
        header("Location: index.php");
    }
    
?>