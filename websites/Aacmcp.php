<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("Aacmcp.html");
        include("database.php");
        include("database2.php");

        $ucount = 0;
        $pcount = 0;
        $ccount = 0;

        $query1 = 'SELECT * FROM parks';
        $result1 = $conn2->query($query1);
        while ($row = $result1->fetch_assoc()) {
            $pcount++;
            $ccount = $ccount + $row['occupied'];
        }

        $query = 'SELECT * FROM login';
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $ucount++;
        }
        
        echo
        "
            <div class='content-body'>

                <div class='row page-titles mx-0'>
                    <div class='col-sm-6 p-md-0'></div>
                </div>

                <div class='container-fluid'>
                    <div class='row justify-content-between mb-3'>
                        <div class='col-12 '>
                            <h2 class='page-heading'>Admin Interface</h2>
                            <p class='mb-0'>Welcome back Admin</p>
                        </div>
                    </div>
                </div>

                <div class='container-fluid'>
                    <div align = 'center' class='row'>
                        <div class='col-xl-6'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h5 class='card-title'>User Statistics</h5>
                                    <p class='card-text'>There are currently $ucount users.</p>
                                </div>
                                <div class='card-footer'>
                                    <a href='userm.php' class='card-link float-right'>User Table</a>
                                </div>
                            </div>
                        </div>
                        <div class='col-xl-6'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Parking Lot Statistics</h5>
                                    <p class='card-text'>There are currently $pcount parking lots with $ccount cars total.</p>
                                </div>
                                <div class='card-footer'>
                                    <a href='parkinglotm.php' class='card-link float-right'>Parking Lot Table</a>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div align = 'center'>
                            <div  style = 'height:550px; width:550px;'>
                                <canvas id='myChart'></canvas>
                            </div>
                            <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
                            <script>
                                const ctx = document.getElementById('myChart');

                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                    labels: [
    ";
    
    $query = 'SELECT * FROM login';
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        echo
        "
        '$row[username]',
        ";
        }
    
    echo"

                                    ],
                                    datasets: [{
                                        label: 'Number Of Parks',
                                        data: [
    ";
    $query = 'SELECT * FROM login';
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $data = 0;
        $query1 = "SELECT * FROM parks WHERE ownerid = '$row[id]' ";
        $result1 = $conn2->query($query1);
        while ($row = $result1->fetch_assoc()) {
            $data++;
        }
        echo
        "
        '$data',
        ";
        }

    echo"
                                        ],
                                        backgroundColor: [
                                        'rgb(0,255,255)',
                                        'rgb(0,200,255)',
                                        'rgb(0,150,255)',
                                        'rgb(0,100,255)',
                                        'rgb(0,50,255)',
                                        'rgb(0,0,255)'
                                        ],
                                        borderWidth: 5
                                    }]
                                    },
                                    options: {
                                    
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

        

        ";
    }
    else{
        header("Location: login.php");
    }
    
?>