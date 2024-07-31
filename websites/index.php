<?php
    include("index.html");
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(!empty($username) && !empty($password)){
            $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";

            $result = $conn->query($query);

            if($result->num_rows ==1){ 
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;

                if(!strcmp($username, "admin")){
                    header("Location: Aacmcp.php");
                    
                }
                else{
                    header("Location: acmcp.php");
                }


                exit();
            }
            else{
                session_start();
                $_SESSION["errormessage"] = "No such User";
                header("Location: loginfailed.php");
                exit();
            }

        }
        elseif(empty($username)){
            session_start();
            $_SESSION["errormessage"] = "Enter an Username";
            header("Location: loginfailed.php");
        }
        elseif(empty($password)){
            session_start();
            $_SESSION["errormessage"] = "Enter a Password";
            header("Location: loginfailed.php");
            
        }

        $conn->close();
    }



?>