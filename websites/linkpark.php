<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("userm.html");
        include("database.php");

        $query = 'SELECT * FROM login';
        $result = $conn->query($query);

        if(isset($_GET["id"])){
           
            $id = $_GET["id"];
      
        }


        echo 
        "<div class = 'container'>
            <br>
            <br> 
            <h2> Link Park </h2>
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
                                <a class = 'btn btn-primary btn-sm' href =  'linked.php?id=$row[id]/$id'> Link </a>
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