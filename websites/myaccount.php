<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("myaccount.html");
        include("database.php");

        $id = $_SESSION["id"];
        
        $query = "SELECT * FROM login WHERE id = $id ";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        echo
        "
        <div class = 'container'>
            <br>
            <br> 
            <h2> Hello $row[username]</h2>
            <br>
            <a class = 'btn btn-primary btn-sm' href =  'chpassword.php?id=$id;'> Change Password </a>
            <br>
        </div>

        ";
    }
    else{
        header("Location: index.php");
    }
    
?>