<?php
    session_start();
    if($_SESSION["validate"] == 1){
        
        include("database2.php");
        
        
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            $id = explode("/", $id);

            $query = "UPDATE parks SET ownerid = '$id[0]' WHERE id = '$id[1]'";
            $result = $conn2->query($query);
            header("Location: parkinglotm.php");

                
        }
        

    }
    else{
        header("Location: index.php");
    }
    
?>