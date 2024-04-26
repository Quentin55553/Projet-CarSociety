<?php 
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['just_ordered'] = "true";
        $_SESSION['panier'] = [];

        header("Location: ../index.php");

        exit();
    }
?>
