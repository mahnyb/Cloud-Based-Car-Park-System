<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("parkdetails.html");
        include("database2.php"); 

        $id = $_GET["id"];
        
        $query = "SELECT * FROM parks WHERE id = $id ";
        $result = $conn2->query($query);
        $row = $result->fetch_assoc();

        
        $ratio = floor($row["occupied"] * (360/$row["slots"]));
        $deg = $ratio . "deg";
        
        echo 
        "
        <div class = 'container'>
            <br>
            <br>
            <h2> $row[name] Park </h2>
            <style>
                .piechart{
                    background-image: conic-gradient(
                        blue $deg,
                        cyan 0deg
                    );
             }
            </style>
            <br>
            <div class='piechart'></div>
            <br>
            <h4> Availability $row[occupied]/$row[slots] </h4>
        </div>

        ";
        

    
    }
    else{
        header("Location: index.php");
    }
    
?>