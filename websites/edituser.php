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
                    <div class='content-body'>
    
                <div class='row page-titles mx-0'>
                    <div class='col-sm-6 p-md-0'></div>
                </div>
    
                <div class='container-fluid'>
                    <div class='login-bg h-100'>
                        <br>
                        <br>
                        <div class='container h-100'>
                            <div class='row justify-content-center h-100'>
                                <div class='col-md-5'>
                                    <div class='form-input-content'>
                                        <div class='card card-login'>
                                            <div class='card-header'>
                                                <div class='nav-header position-relative  text-center w-100'>
                                                    <div class='brand-logo'>
                                                        <a href='javascript:void(0)'>
                                                            <b class='logo-abbr'>ACMCP</b>
                                                            <span class='brand-title'><b>Edit User</b></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='card-body'>
                                                <form action = 'edituser.php' method= 'post'>
                                                    <div class='form-group mb-4'>
                                                        <input type = 'hidden' name = 'id' value = '$id'>
                                                    </div>    
                                                    <div class='form-group mb-4'>
                                                        <input type='text' class='form-control rounded-0 bg-transparent' name ='editedusername' placeholder='$phname'>
                                                    </div>
                                                    <div class='form-group mb-4'>
                                                        <input type='text' class='form-control rounded-0 bg-transparent' name ='editedpassword' placeholder= '$phpassword'>
                                                    </div>
                                                    <button class='btn btn-primary btn-block border-0' type='submit'>Edit User</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                ?>
                <script type="text/javascript">
                window.location.href = 'userm.php';
                </script>
                <?php
                


                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to edit user </label>
                        <br>
                        <a class = 'btn btn-danger' href = 'userm.php' role = 'button'> Proceed </a>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($editedusername)){
                echo
                "
                <br>
                <br>
                <div class='container-fluid'>
                    <div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Enter Username </label>
                        <br>
                        <a class = 'btn btn-danger' href = 'userm.php' role = 'button'> Proceed </a>
                        <hr>
                    </div>
                </div>";
            }
            elseif(empty($editedpassword)){
                echo
                "
                <br>
                <br>
                <div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Password </label>
                    <br>
                    <a class = 'btn btn-danger' href = 'userm.php' role = 'button'> Proceed </a>
                    <hr>
                </div>";   
            }
    
        }

        $conn->close();

    }
    else{
        header("Location: login.php");
    }
    
?>