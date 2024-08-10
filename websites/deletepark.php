<?php
    session_start();
    if($_SESSION["validate"] == 1){
        
        include("database2.php");
        
        
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            
            $query = "DELETE FROM parks WHERE id = '$id'";
            $result = $conn2->query($query);              
            
            
            header("Location: parkinglotm.php");

                
        }
        

    }
    else{
        header("Location: index.php");
    }
    
?>