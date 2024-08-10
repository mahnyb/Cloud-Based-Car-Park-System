<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("edituser.html");
        include("database.php");

        $id = "";
        $editedusername = "";
        $editedusername = "";
        $phname ="";
        $phpassword ="";

        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(!isset($_GET["id"])){
                header("Location: userm.php");
                
            }

            $id = $_GET["id"];

            $query = "SELECT * FROM login WHERE id = $id ";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();

            $phname = $row["username"];
            $phpassword = $row["password"];
       
        echo
        "
        <form align = center action = 'edituser.php' method= 'post'>
            <input type = 'hidden' name = 'id' value = '$id'>
            <label> Edit Username: </label><br>
            <input type = 'text' name = 'editedusername' placeholder = '$phname'><br>

            <label> Edit Password: </label><br>
            <input type = 'text' name = 'editedpassword' placeholder = '$phpassword'><br>

            <br>
            <input type = 'submit' value = 'Edit User' class = 'btn btn-primary' >
        </form>
        <br>
        ";

        }



        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedusername = filter_input(INPUT_POST, "editedusername", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedpassword = filter_input(INPUT_POST, "editedpassword", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($editedusername) && !empty($editedpassword)){

                if($id == 1){
                    $query = "UPDATE login SET password = '$editedpassword' WHERE id = '$id'";
                    $result = $conn->query($query);                  
                }
                else{
                    $query = "UPDATE login SET username = '$editedusername', password = '$editedpassword' WHERE id = '$id'";
                    $result = $conn->query($query);
                }
                header("Location: userm.php");
                


                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to edit user </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($editedusername)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Username </label>
                    <hr>
                </div>";
            }
            elseif(empty($editedpassword)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Password </label>
                    <hr>
                </div>";   
            }
    
        }

        $conn->close();

    }
    else{
        header("Location: index.php");
    }
    
?>