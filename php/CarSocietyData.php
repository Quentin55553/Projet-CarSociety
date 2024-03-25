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
function xml_to_array_products(){
    libxml_use_internal_errors(true);
    $xml=simplexml_load_file("../bdd/products.xml");
    if ($xml === false) {
        echo "Failed loading XML: ";
        /*
        foreach(libxml_get_errors() as $error) {
          echo "<br>", $error->message;
        }
        */
    } 
    else{
        $products=[];
        foreach ($xml->children() as $cat){
            $products[$cat->getName()]=[];
            $i=0;
            foreach($cat->children() as $car){
                $tab=["Image","Référence","Nom","Prix","Stock"];
                $tab[0]=$car->img->__toString();
                $tab[1]=$car->reference->__toString();
                $tab[2]=$car->nom->__toString();
                $tab[3]=(int) $car->prix;
                $tab[4]=(int) $car->stock;
                $products[$cat->getName()][] = $tab;
            }
        }
        return $products;
    }
}

/*
Lecture du .xml, mise à jour du stock d'un produit dans le fichier et dans sql
*/
function maj_db_productstock($reference){
    
}

?>