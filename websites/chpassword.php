<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("chpassword.html");
        include("database.php");

        $id = "";
        $newpassword = "";
        $newpasswordconfirm = "";
        $oldpassword ="";

        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(!isset($_GET["id"])){
                header("Location: myaccount.php");
                
            }

            $id = $_GET["id"];

            $query = "SELECT * FROM login WHERE id = $id ";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
       
        echo
        "
        <form align = center action = 'chpassword.php' method= 'post'>
            <input type = 'hidden' name = 'id' value = '$id'>
            <label> Old Password: </label><br>
            <input type = 'password' name = 'oldpassword' placeholder = '******'><br>

            <label> New Password: </label><br>
            <input type = 'password' name = 'newpassword' placeholder = '******'><br>

            <label> Confirm Password: </label><br>
            <input type = 'password' name = 'newpasswordconfirm' placeholder = '******'><br>

            <br>
            <input type = 'submit' value = 'Change Password' class = 'btn btn-primary' >
        </form>
        <br>
        ";

        }



        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpasswordconfirm = filter_input(INPUT_POST, "newpasswordconfirm", FILTER_SANITIZE_SPECIAL_CHARS);
            $oldpassword = filter_input(INPUT_POST, "oldpassword", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($oldpassword) && !empty($newpassword) && !empty($newpasswordconfirm)){

                $query = "SELECT * FROM login WHERE id = $id ";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();

                if(!strcmp($oldpassword, $row["password"])){
                    if(!strcmp($newpassword,$newpasswordconfirm)){
                        $query = "UPDATE login SET password = '$newpassword' WHERE id = '$id'";
                        $result = $conn->query($query);
                        echo
                        "<div align = center style = 'background-color: green; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Sucsess!</label>
                        <br>
                        <label style = 'color:white;'> Password Changed </label>
                        <hr>
                         </div>";                
                        
                    }
                    else{
                        echo
                        "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                            <br>
                            <label style = 'color:white; font-size: large;'> Warning!</label>
                            <br>
                            <label style = 'color:white;'> New Passwords don't match </label>
                            <hr>
                        </div>";
                    }

                }
                else{
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Old Password wrong </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($oldpassword)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Old Password </label>
                    <hr>
                </div>";
            }
            elseif(empty($newpassword)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter New Password </label>
                    <hr>
                </div>";   
            }
            elseif(empty($newpasswordconfirm)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Confirm Password </label>
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