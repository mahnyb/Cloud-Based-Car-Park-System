<?php
    session_start();
    if($_SESSION["validate"] == 2){
        $username = $_SESSION["username"];
        include("acmcp.html");
        include("database.php");
        include("database2.php");
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
						<h2 class='page-heading'>User Interface</h2>
					</div>
                </div>
            </div>

            <div class='container-fluid'>
        ";
        $query = "SELECT * FROM parks WHERE ownerid = '$id'";
        $result = $conn2->query($query);
        while($row = $result->fetch_assoc()){
            echo
            "
                <div class='row'>
                    <div class='col-xl-12'>
                        <div class='card mb-3'>
                            <div class='card-body'>
                                <h5 class='card-title'>$row[name] Park</h5>
                                <h8 class='card-title'>Availability: $row[occupied]/$row[slots]</h8> 
                                <br>
                                <h8 class='card-title'>Region: $row[region]</h8>

                            </div>
                            <div class='card-footer'>
                                <a href='parkdetails.php?id=$row[id]' class='card-link float-right'>Park Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            ";

        }


        echo
        "
            </div>
        </div>


        <script src='../../assets/plugins/common/common.min.js'></script>
        <script src='../js/custom.min.js'></script>
        <script src='../js/settings.js'></script>
        <script src='../js/quixnav.js'></script>
        <script src='../../assets/plugins/raphael/raphael.min.js'></script>
        <script src='../../assets/plugins/morris/morris.min.js'></script>
        <script src='../js/plugins-init/charts-init.js'></script>


        ";
    }
    else{
        header("Location: login.php");
    }
    
?>