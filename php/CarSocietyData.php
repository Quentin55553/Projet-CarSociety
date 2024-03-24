<?php
// SCRIPT POUR GERER LA BASE DE DONNEES DE CAR SOCIETY A PARTIR DES FICHIERS JSON ET XML
// (COMPTE ROOT SANS MOT DE PASSE)

////////////////////////////////////////////////
////// CONNEXION A LA BASE DE DONNEES///////////
////////////////////////////////////////////////

// TRUE si se connecter à la base est possible, FALSE sinon
function connect_db(){
    try{
        // Login utilisateur (compte root sans mot de passe)
        $username = "root";
        $password = "";
        // Connexion à SQL
        $db = new PDO('mysql:host=localhost;port=8080', $username, $password);
        // Connexion sur la base de données CarSociety
        $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety',$username, $password);
        $db = null;
        return TRUE;
    }
    catch(Exception $e){
        return FALSE;
    }    
}

// ????? Pas possible ?????
// True si se déconnecter de la base est possible (et le fait), False sinon
function disconnect_db(){

}

////////////////////////////////
//////// LECTURE Users /////////
////////////////////////////////


////////////////////////////////
//////// LECTURE Products //////
////////////////////////////////


////////////////////////////////
////// MISE A JOUR Users ///////
////////////////////////////////

/*
Initialisation des valeurs de la base de données sql à partir du .json
*/
function init_db_users(){

}

/*
Lecture du .json, ajout des nouveaux comptes à la BDD SQL
*/
function maj_db_users(){

}


////////////////////////////////
////// MISE A JOUR Products/////
////////////////////////////////
/*
Initialisation des valeurs de la base de données sql à partir du .xml
*/
function init_db_products(){

}

/*
Lecture du .xml, mise à jour du stock d'un produit dans le fichier et dans sql
*/
function maj_db_productstock($reference){
    
}

?>