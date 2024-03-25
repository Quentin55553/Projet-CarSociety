<?php
    session_start();

    if(!isset($_SESSION['user'])) {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la page d'accueil
        header("Location: ../index.php");
    }

    // On déconnecte la session de l'utilisateur
    unset($_SESSION['user']);
    session_destroy();

    // On redirige l'utilisateur vers la page d'accueil après l'avoir déconnecté
    header("Location: ../index.php");
    exit();
?>
