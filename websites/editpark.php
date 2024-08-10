<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("editpark.html");
        include("database2.php");

        $id = "";
        $editedname = "";
        $editedowner = "";
        $editedslots = "";
        $editedoccupied = "";
        $phname ="";
        $phowner ="";
        $phslots ="";
        $phoccupied ="";

        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(!isset($_GET["id"])){
                header("Location: parkinglotm.php");
                
            }

            $id = $_GET["id"];

            $query = "SELECT * FROM parks WHERE id = $id ";
            $result = $conn2->query($query);
            $row = $result->fetch_assoc();

            $phname = $row["name"];
            $phslots = $row["slots"];
            $phoccupied = $row["occupied"];
       
        echo
        "
        <form align = center action = 'editpark.php' method= 'post'>
            <input type = 'hidden' name = 'id' value = '$id'>
            <label> Edit Name: </label><br>
            <input type = 'text' name = 'editedname' placeholder = '$phname'><br>

            <label> Edit Slots: </label><br>
            <input type = 'text' name = 'editedslots' placeholder = '$phslots'><br>

            <label> Edit Occupied Slots: </label><br>
            <input type = 'text' name = 'editedoccupied' placeholder = '$phoccupied'><br>

            <br>
            <input type = 'submit' value = 'Edit Park' class = 'btn btn-primary' >
        </form>
        <br>
        ";

        }



        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedname = filter_input(INPUT_POST, "editedname", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedslots = filter_input(INPUT_POST, "editedslots", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedoccupied = filter_input(INPUT_POST, "editedoccupied", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($editedname) && !empty($editedslots) && !empty($editedoccupied)){

                if($editedoccupied > $editedslots){
                    $editedoccupied = $editedslots;
                }
                $query = "UPDATE parks SET name = '$editedname', slots = '$editedslots', occupied = '$editedoccupied' WHERE id = '$id'";
                $result = $conn2->query($query);
                header("Location: parkinglotm.php");
            
                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to edit Parking Lot </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($editedname)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter a Name </label>
                    <hr>
                </div>";
            }
            elseif(empty($editedslots)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Slots </label>
                    <hr>
                </div>";   
            }
            elseif(empty($editedoccupied)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Occupied Slots </label>
                    <hr>
                </div>";   
            }
        }
    
        

        $conn2->close();

    }
    else{
        header("Location: index.php");
    }
    
?>