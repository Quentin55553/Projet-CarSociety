<?php
    session_start();

    if (isset($_GET['cat'])) {
        $catValue = $_GET['cat'];

        header("Location: login.php?cat=" . urlencode($catValue));
        exit();
    }

    header("Location: login.php");
    exit();
?>
