<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("myparkinglots.html");
        include("database2.php");

        $id = $_SESSION["id"] ;

        echo
        "
        <div class = 'container'>
            <br>
            <br> 
            <h2> My Parking Lots </h2>
            <br>
            <br>
        ";

        $query = 'SELECT * FROM parks';
        $result = $conn2->query($query);

        while($row = $result->fetch_assoc()){
           
            if($row["ownerid"] == $id){
                           
            echo
            "
            <a class = 'parkbutton' href =  'parkdetails.php?id=$row[id]'> $row[name] Park </a>
            ";

            }


        }

        echo
        "
        </div>
        ";
        


    }
    else{
        header("Location: index.php");
    }
    
?>