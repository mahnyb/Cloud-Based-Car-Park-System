<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("adduser.html");
        include("database.php");
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $newusername = filter_input(INPUT_POST, "newusername", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($newusername) && !empty($newpassword)){
                $query = "INSERT INTO login (username,password)" . "VALUES ('$newusername', '$newpassword')";
                $result = $conn->query($query);
                header("Location: userm.php");

                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to add user </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($newusername)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Username </label>
                    <hr>
                </div>";
            }
            elseif(empty($newpassword)){
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