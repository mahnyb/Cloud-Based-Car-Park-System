<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name ="parkinglots";
    $conn2 ="";
    
    try{
        $conn2 = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }
    catch(mysqli_sql_exception){
        echo "No Database";
    }
    

?>