<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("userm.html");
        include("database.php");

        $query = 'SELECT * FROM login';
        $result = $conn->query($query);


        echo 
        "
        
            <div class='col-12'>
                <div class = 'row'>
                    <br> 
                    <h2> User Table </h2>
                    <br>
                </div>
            </div>
            <div class='col-12'>
                <div class = 'row'>
                    <br>
                    <a class = 'btn btn-primary' href = 'adduser.php' role = 'button'> Add User </a>
                    <br>
                </div>
            </div>
            <br>
        
        ";
        while($row = $result->fetch_assoc()){
            echo
                "

                                                    <tr>
                                                        <td> $row[id] </td>
                                                        <td> $row[username] </td>
                                                        <td> $row[password] </td>
                                                        <td> 
                                                            <a class = 'btn btn-primary btn-sm' href =  'edituser.php?id=$row[id]'> Edit </a>
                                                            <a class = 'btn btn-danger btn-sm' href =  'deleteuser.php?id=$row[id]'> Delete </a>
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

        $conn->close();


    }
    else{
        header("Location: login.php");
    }
    
?>
