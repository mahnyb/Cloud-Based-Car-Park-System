<?php
    session_start();
    include("loginfailed.html");

?>

<?= 
    "<div align = center style = 'background-color: red; width: 400px; border-style: groove; margin-left: 750px'>
            <br>
            <label style = 'color:white; font-size: large;'> Warning!</label>
            <br>
            <label style = 'color:white;'> {$_SESSION['errormessage']} </label>
            <hr>
            
    </div>" 
?> 