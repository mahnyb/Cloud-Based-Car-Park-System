<?php
    $_SESSION["validate"] = 0;
    session_destroy();
    header("Location: index.php");
?>