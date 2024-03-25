<?php
    // SCRIPT POUR (RE)INITIALISER LA BASE DE DONNEES DE CAR SOCIETY
    // (COMPTE ROOT SANS MOT DE PASSE)
    session_start();


    function carsociety() {
        try {
            // Login utilisateur (compte root sans mot de passe)
            $username = "root";
            $password = "";

            // Connexion à SQL
            $db = new PDO('mysql:host=localhost;port=8080', $username, $password);
            // Création de la base de données CarSociety
            $sql = "CREATE DATABASE IF NOT EXISTS CarSociety";
            $db->exec($sql);
            $db = null;

            // Connexion sur la base de données CarSociety
            $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety', $username, $password);
            // Destruction des tables existantes
            $sql = "DROP TABLE IF EXISTS Users;
                    DROP TABLE IF EXISTS Products;";
            $db->exec($sql);
            // Création de la table Users
            $sql = "CREATE TABLE Users(
                    id int PRIMARY KEY,
                    nom VARCHAR(50),
                    prenom VARCHAR(50),
                    ddn date,
                    email VARCHAR(50),
                    tel VARCHAR(50),
                    mdp VARCHAR(50))";
                    
            $db->exec($sql);

            // Création de la table Products
            $sql = "CREATE TABLE Products(
                    reference VARCHAR(50) PRIMARY KEY,
                    cat VARCHAR(50),
                    nom VARCHAR(50),
                    prix int,
                    stock int,
                    img VARCHAR(50));";
            $db->exec($sql);

            // Fermeture de la base de données
            $db = null;
        
        } catch(Exception $e) {
            echo "Erreur: ".$e->getMessage()."<br/>";
            die();
        }
    }

    // Exécution
    carsociety();
?>
