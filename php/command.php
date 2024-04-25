<?php 
    session_start();
    commander();

    function commander() {
        $_SESSION['just_ordered'] = "true";
        $_SESSION['panier']=[];
        header("Location: ../index.php");
        exit();
    }
?>