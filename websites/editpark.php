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
                                                            <span class='brand-title'><b>Edit Parking Lot</b></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='card-body'>
                                                <form action = 'editpark.php' method= 'post'>
                                                    <div class='form-group mb-4'>
                                                        <input type = 'hidden' name = 'id' value = '$id'>
                                                    </div>    
                                                    <div class='form-group mb-4'>
                                                        <input type='text' class='form-control rounded-0 bg-transparent' name ='editedname' placeholder='$phname'>
                                                    </div>
                                                    <div class='form-group mb-4'>
                                                        <input type='text' class='form-control rounded-0 bg-transparent' name ='editedslots' placeholder= '$phslots'>
                                                    </div>
                                                    <div class='form-group mb-4'>
                                                        <input type='text' class='form-control rounded-0 bg-transparent' name ='editedoccupied' placeholder= '$phoccupied'>
                                                    </div>
                                                    <button class='btn btn-primary btn-block border-0' type='submit'>Edit Park</button>
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
            $editedname = filter_input(INPUT_POST, "editedname", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedslots = filter_input(INPUT_POST, "editedslots", FILTER_SANITIZE_SPECIAL_CHARS);
            $editedoccupied = filter_input(INPUT_POST, "editedoccupied", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($editedname) && !empty($editedslots) && !empty($editedoccupied)){

                if($editedoccupied > $editedslots){
                    $editedoccupied = $editedslots;
                }
                $query = "UPDATE parks SET name = '$editedname', slots = '$editedslots', occupied = '$editedoccupied' WHERE id = '$id'";
                $result = $conn2->query($query);
                ?>
                <script type="text/javascript">
                window.location.href = 'parkinglotm.php';
                </script>
                <?php
            
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
                "
                <br>
                <br>
                <div class='container-fluid'>
                    <div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Enter Name </label>
                        <br>
                        <a class = 'btn btn-danger' href = 'parkinglotm.php' role = 'button'> Proceed </a>
                        <hr>
                    </div>
                </div>";
            }
            elseif(empty($editedslots)){
                echo
                "
                <br>
                <br>
                <div class='container-fluid'>
                    <div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Enter Slots </label>
                        <br>
                        <a class = 'btn btn-danger' href = 'parkinglotm.php' role = 'button'> Proceed </a>
                        <hr>
                    </div>
                </div>";  
            }
            elseif(empty($editedoccupied)){
                echo
                "
                <br>
                <br>
                <div class='container-fluid'>
                    <div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Enter Occupied </label>
                        <br>
                        <a class = 'btn btn-danger' href = 'parkinglotm.php' role = 'button'> Proceed </a>
                        <hr>
                    </div>
                </div>";  
            }
        }
    
        

        $conn2->close();

    }
    else{
        header("Location: login.php");
    }
    
?>