<?php
    session_start();

    $_SESSION['need_connect'] = true;
    
    header("Location: login.php");
    exit();
?>
