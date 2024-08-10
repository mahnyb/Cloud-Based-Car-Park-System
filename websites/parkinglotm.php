<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("parkinglotm.html");
        include("database.php");
        include("database2.php");

        $query = 'SELECT * FROM parks';
        $result = $conn2->query($query);




        echo 
        "<div class = 'container'>
            <br>
            <br> 
            <h2> Parking Lots </h2>
            <br>
            <a class = 'btn btn-primary' href = 'addpark.php' role = 'button'> Add Parking Lot </a>
            <br>
            <br>
            <table class = 'usertable' border = '2'>
                <thead>
                    <tr align = 'center'>
                        <th width = '30'> ID </th>
                        <th width = '150'> Name </th>
                        <th width = '150'> Owner </th>
                        <th width = '150'> Availability </th>
                        <th width = '200'>  </th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()){
            $query1 = "SELECT * FROM login WHERE id = $row[ownerid] ";
            $result1 = $conn->query($query1);
            $row1 = $result1->fetch_assoc();
            echo
                "

                        <tr align = 'center'>
                            <td> $row[id] </td>
                            <td> $row[name] </td>
                            <td> $row1[username] </td>
                            <td> $row[occupied]/$row[slots] </td>
                            <td> 
                                <a class = 'btn btn-primary btn-sm' href =  'editpark.php?id=$row[id]'> Edit </a>
                                <a class = 'btn btn-danger btn-sm' href =  'deletepark.php?id=$row[id]'> Delete </a>
                                <a class = 'btn btn-secondary btn-sm' href =  'linkpark.php?id=$row[id]'> Link </a>
                            </td>
                        </tr>";
            }
        echo
        "
                </tbody>

            </table>
            
         
        </div>";

        $conn2->close();


    }
    else{
        header("Location: index.php");
    }
    
?>
