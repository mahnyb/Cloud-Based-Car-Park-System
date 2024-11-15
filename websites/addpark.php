<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("addpark.html");
        include("database2.php");
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
                                                        <span class='brand-title'><b>Enter New Park</b></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='card-body'>
                                            <form action = 'addpark.php' method= 'post'>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='name' placeholder='New Park Name'>
                                                </div>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='slots' placeholder='New Park Slots'>
                                                </div>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='occupied' placeholder=' New Park Occupied Slots'>
                                                </div>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='region' placeholder=' Location/Super Region'>
                                                </div>
                                                <div class='form-group mb-4'>
                                                    <input type='text' class='form-control rounded-0 bg-transparent' name ='plate' placeholder=' Plate '>
                                                </div>
                                                <button class='btn btn-primary btn-block border-0' type='submit'>Add Park</button>
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

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $slots = filter_input(INPUT_POST, "slots", FILTER_SANITIZE_SPECIAL_CHARS);
            $occupied = filter_input(INPUT_POST, "occupied", FILTER_SANITIZE_SPECIAL_CHARS);
            $region = filter_input(INPUT_POST, "region", FILTER_SANITIZE_SPECIAL_CHARS);
            $plate = filter_input(INPUT_POST, "plate", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($name) && !empty($slots) && !empty($occupied)){

                if($occupied > $slots){
                    $occupied = $slots;
                }
                $hash = rand(10000,99999);
                $query = "INSERT INTO parks (name,ownerid,slots,occupied,region,hash,plate)" . "VALUES ('$name','1', '$slots', '$occupied','$region','$hash','$plate')";
                $result = $conn2->query($query);
                ?>
                <script type="text/javascript">
                window.location.href = 'parkinglotm.php';
                </script>
                <?php

                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to add parking lot </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($name)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter a name </label>
                    <hr>
                </div>";
            }
            elseif(empty($slots)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter slots </label>
                    <hr>
                </div>";   
            }
            elseif(empty($occupied)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 625px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter occupied slots </label>
                    <hr>
                </div>";   
            }
        }

        $conn2->close();

    }
    else{
        header("Location: login.php");
    }
    
?>