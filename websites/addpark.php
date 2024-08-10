<?php
    session_start();
    if($_SESSION["validate"] == 1){
        include("addpark.html");
        include("database2.php");
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $slots = filter_input(INPUT_POST, "slots", FILTER_SANITIZE_SPECIAL_CHARS);
            $occupied = filter_input(INPUT_POST, "occupied", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($name) && !empty($slots) && !empty($occupied)){

                if($occupied > $slots){
                    $occupied = $slots;
                }
                $query = "INSERT INTO parks (name,ownerid,slots,occupied)" . "VALUES ('$name','1', '$slots', '$occupied')";
                $result = $conn2->query($query);
                header("Location: parkinglotm.php");

                if(!$result) {
                    echo
                    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                        <br>
                        <label style = 'color:white; font-size: large;'> Warning!</label>
                        <br>
                        <label style = 'color:white;'> Unable to add parking lot </label>
                        <hr>
                    </div>";
                }

            }
            elseif(empty($name)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter a name </label>
                    <hr>
                </div>";
            }
            elseif(empty($slots)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter slots </label>
                    <hr>
                </div>";   
            }
            elseif(empty($occupied)){
                echo
                "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
                    <br>
                    <label style = 'color:white; font-size: large;'> Warning!</label>
                    <br>
                    <label style = 'color:white;'> Enter occupied slots </label>
                    <hr>
                </div>";   
            }
        }

        $conn2->close();

    }
    else{
        header("Location: index.php");
    }
    
?>