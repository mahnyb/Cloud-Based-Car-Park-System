<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("linkpark.html");
        include("database.php");

        $query = 'SELECT * FROM login';
        $result = $conn->query($query);

        if(isset($_GET["id"])){
           
            $id = $_GET["id"];
      
        }


        echo 
        "
        
            <div class='col-12'>
                <div class = 'row'>
                    <br> 
                    <h2> Link Park </h2>
                    <br>
                </div>
            </div>
            <div class='col-12'>
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
                                                            <a class = 'btn btn-secondary btn-sm' href =  'linked.php?id=$row[id]/$id'> Link </a>
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