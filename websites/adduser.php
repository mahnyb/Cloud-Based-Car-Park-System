<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("adduser.html");
        include("database.php");
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
                                                        <span class='brand-title'><b>Enter New User</b></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='card-body'>
                                            <form action = 'adduser.php' method= 'post'>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='newusername' placeholder='New Username'>
                                                </div>
                                                <div class='form-group mb-4'>
                                                    <input type='password' class='form-control rounded-0 bg-transparent' name ='newpassword' placeholder=' New Password'>
                                                </div>
                                                <button class='btn btn-primary btn-block border-0' type='submit'>Add User</button>
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
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $newusername = filter_input(INPUT_POST, "newusername", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($newusername) && !empty($newpassword)){
                $query = "INSERT INTO login (username,password)" . "VALUES ('$newusername', '$newpassword')";
                $result = $conn->query($query);
                ?>
                <script type="text/javascript">
                window.location.href = 'userm.php';
                </script>
                <?php
                

                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 10px; border-style: groove; margin-left: 625px'>
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
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Username </label>
                    <hr>
                </div>";
            }
            elseif(empty($newpassword)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
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
        header("Location: login.php");
    }
    
?>