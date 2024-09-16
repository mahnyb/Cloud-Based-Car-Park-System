<?php
    session_start();
    if($_SESSION["validate"] == 2){
        include("chpassword.html");
        include("database.php");
        include("database2.php");

        $username = $_SESSION["username"];

        echo 
        "
                        <a class='has-arrow' href='javascript:void()' aria-expanded='false'>
                            <span class='nav-text'>My Parking Lots</span>
                        </a>
                        <ul aria-expanded='false'>
        ";
        
        $query1 = "SELECT * FROM login WHERE username = '$username'";
        $result1 = $conn->query($query1);
        $row = $result1->fetch_assoc();
        $id = $row['id'];

        $query = "SELECT * FROM parks WHERE ownerid = '$id'";
        $result = $conn2->query($query);
        while($row = $result->fetch_assoc()){
            echo
            "
                            <li><a href='parkdetails.php?id=$row[id]'>$row[name] Park</a></li>
            ";

        }


        echo
        "
                        
                        </ul>
                    </li>
                    
                    <li><a class='has-arrow' href='javascript:void()' aria-expanded='false'>
                            <span class='nav-text'>$username's Account</span>
                        </a>
                        <ul aria-expanded='false'>
                            <li><a href='chpassword.php'>Change Password</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class='content-body'>

            <div class='row page-titles mx-0'>
                <div class='col-sm-6 p-md-0'></div>
            </div>

            <div class='container-fluid'>
                <div class='row justify-content-between mb-3'>
					<div class='col-12 '>
						<h2 class='page-heading'>My Account</h2>
					</div>
                </div>
            </div>

            <div class='container-fluid'>
        ";

        $newpassword = "";
        $newpasswordconfirm = "";
        $oldpassword ="";

       
        echo
        "
            <div class='row justify-content-center h-100'>
                <div class='col-md-5'>
                    <div class='form-input-content'>
                        <div class='card-body'>
                            <form action = 'chpassword.php' method= 'post'>
                                <input type = 'hidden' name = 'id' value = '$id'>
                                <div class='form-group mb-4'>
                                    <input type='password' class='form-control rounded-0 bg-transparent' name ='oldpassword' placeholder='Old Password'>
                                </div>
                                <div class='form-group mb-4'>
                                    <input type='password' class='form-control rounded-0 bg-transparent' name ='newpassword' placeholder='New Password'>
                                </div>
                                <div class='form-group mb-4'>
                                    <input type='password' class='form-control rounded-0 bg-transparent' name ='newpasswordconfirm' placeholder='Confirm New Password'>
                                </div>
                                <button class='btn btn-primary btn-block border-0' type='submit'>Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ";

        echo
        "
            


        <script src='../../assets/plugins/common/common.min.js'></script>
        <script src='../js/custom.min.js'></script>
        <script src='../js/settings.js'></script>
        <script src='../js/quixnav.js'></script>
        <script src='../../assets/plugins/raphael/raphael.min.js'></script>
        <script src='../../assets/plugins/morris/morris.min.js'></script>
        <script src='../js/plugins-init/charts-init.js'></script>


        ";



        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_SPECIAL_CHARS);
            $newpasswordconfirm = filter_input(INPUT_POST, "newpasswordconfirm", FILTER_SANITIZE_SPECIAL_CHARS);
            $oldpassword = filter_input(INPUT_POST, "oldpassword", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($oldpassword) && !empty($newpassword) && !empty($newpasswordconfirm)){

                $query = "SELECT * FROM login WHERE id = '$id'";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();

                if(!strcmp($oldpassword, $row["password"])){
                    if(!strcmp($newpassword,$newpasswordconfirm)){
                        $query = "UPDATE login SET password = '$newpassword' WHERE id = '$id'";
                        $result = $conn->query($query);
                        echo
                        "<div align = center style = 'background-color: green; width: 400px; border-style: groove; margin-left: 600px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Sucsess!</label>
                        <br>
                        <label style = 'color:white;'> Password Changed </label>
                        <hr>
                         </div>";                
                        
                    }
                    else{
                        echo
                        "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 600px'>
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
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 600px'>
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
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 600px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter Old Password </label>
                    <hr>
                </div>";
            }
            elseif(empty($newpassword)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 600px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter New Password </label>
                    <hr>
                </div>";   
            }
            elseif(empty($newpasswordconfirm)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 600px'>
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