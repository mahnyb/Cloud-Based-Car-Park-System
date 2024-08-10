<?php
    session_start();
    if($_SESSION["validate"] == 1){
        
        include("database.php");
        
        
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            if($id == 1){
                header("Location: userm.php");
            }
            else{
                $query = "DELETE FROM login WHERE id = '$id'";
                $result = $conn->query($query);              
            }
            
            header("Location: userm.php");

                
        }
        

    }
    else{
        header("Location: index.php");
    }
    
?>