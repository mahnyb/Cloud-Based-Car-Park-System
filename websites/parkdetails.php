<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("parkdetails.html");
        


        $id = $_GET["id"];
        echo $id;
        echo "Not Done";
        

    
    }
    else{
        header("Location: index.php");
    }
    
?>