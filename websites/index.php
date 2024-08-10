<?php
    include("index.html");
    include("database.php");

    session_start();
    $_SESSION["validate"] = 0;


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(!empty($username) && !empty($password)){
            $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";

            $result = $conn->query($query);

            $id = $result->fetch_assoc();



            if($result->num_rows ==1){;
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $_SESSION["id"] = $id["id"];

                if(!strcmp($username, "admin")){
                    $_SESSION["validate"] = 1;
                    header("Location: Aacmcp.php");
                    
                }
                else{
                    $_SESSION["validate"] = 2;
                    header("Location: acmcp.php");
                }


                exit();
            }
            else{
                $_SESSION["errormessage"] = "No such User";
                header("Location: loginfailed.php");
                exit();
            }

        }
        elseif(empty($username)){
            $_SESSION["errormessage"] = "Enter an Username";
            header("Location: loginfailed.php");
        }
        elseif(empty($password)){
            $_SESSION["errormessage"] = "Enter a Password";
            header("Location: loginfailed.php");
            
        }

        $conn->close();
    }



?>