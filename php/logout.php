<?php
    session_start();

    if(!isset($_SESSION['user'])){
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header("Location: index.php");
    }

    // Déconnecte la session de l'utilisateur
    unset($_SESSION['user']);
    session_destroy();

    // Redirection vers la page d'accueil après avoir déconnecté l'utilisateur
    header("Location: index.php");
    exit();
?>
