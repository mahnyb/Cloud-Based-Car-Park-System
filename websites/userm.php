<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("userm.html");
        include("database.php");

        $query = 'SELECT * FROM login';
        $result = $conn->query($query);


        echo 
        "<div class = 'container'>
            <br>
            <br> 
            <h2> Users </h2>
            <br>
            <a class = 'btn btn-primary' href = 'adduser.php' role = 'button'> Add User </a>
            <br>
            <br>
            <table class = 'usertable' border = '2'>
                <thead>
                    <tr align = 'center'>
                        <th width = '30'> ID </th>
                        <th width = '150'> Username </th>
                        <th width = '150'> Password </th>
                        <th width = '150'>  </th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()){
            echo
                "

                        <tr align = 'center'>
                            <td> $row[id] </td>
                            <td> $row[username] </td>
                            <td> $row[password] </td>
                            <td> 
                                <a class = 'btn btn-primary btn-sm' href =  'edituser.php?id=$row[id]'> Edit </a>
                                <a class = 'btn btn-danger btn-sm' href =  'deleteuser.php?id=$row[id]'> Delete </a>
                            </td>
                        </tr>";
            }
        echo
        "
                </tbody>

            </table>
            
         
        </div>";

        $conn->close();


    }
    else{
        header("Location: index.php");
    }
    
?>
