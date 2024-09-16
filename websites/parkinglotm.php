<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("parkinglotm.html");
        include("database.php");
        include("database2.php");

        $query = 'SELECT * FROM parks';
        $result = $conn2->query($query);


        echo 
        "
        
            <div class='col-12'>
                <div class = 'row'>
                    <br> 
                    <h2> Parking Lot Table </h2>
                    <br>
                </div>
            </div>
            <div class='col-12'>
                <div class = 'row'>
                    <br>
                    <a class = 'btn btn-primary' href = 'addpark.php' role = 'button'> Add Park </a>
                    <br>
                </div>
            </div>
            <br>
        
        ";
        while($row = $result->fetch_assoc()){
            $query1 = "SELECT * FROM login WHERE id = $row[ownerid] ";
            $result1 = $conn->query($query1);
            $row1 = $result1->fetch_assoc();
            echo
                "

                                                    <tr>
                                                        <td> $row[id] </td>
                                                        <td> $row[name] </td>
                                                        <td> $row1[username] </td>
                                                        <td> $row[occupied]/$row[slots] </td>
                                                        <td> $row[region] </td>
                                                        <td> $row[hash]  </td>
                                                        <td> 
                                                            <a class = 'btn btn-primary btn-sm' href =  'editpark.php?id=$row[id]'> Edit </a>
                                                            <a class = 'btn btn-danger btn-sm' href =  'deletepark.php?id=$row[id]'> Delete </a>
                                                            <a class = 'btn btn-secondary btn-sm' href =  'linkpark.php?id=$row[id]'> Link </a>
                                                        </td>
                                                    </tr>
                ";
        }
        echo
        "
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        ";

        $conn2->close();


    }
    else{
        header("Location: login.php");
    }
    
?>
