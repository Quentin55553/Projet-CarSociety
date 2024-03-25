<?php
    // SCRIPT POUR GERER LA BASE DE DONNEES DE CAR SOCIETY A PARTIR DES FICHIERS JSON ET XML
    // (COMPTE ROOT SANS MOT DE PASSE)

    ////////////////////////////////////////////////
    ////// CONNEXION A LA BASE DE DONNEES///////////
    ////////////////////////////////////////////////
    $username="root";
    $password="";
    // TRUE si se connecter à la base est possible, FALSE sinon
    function connect_db() {
        try {
            // Login utilisateur (compte root sans mot de passe)
            global $username;
            global $password;
            // Connexion sur la base de données CarSociety
            $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety', $username, $password);
            $db = null;
            return TRUE;
        
        } catch(Exception $e) {
            return FALSE;
        }    
    }

    function db_exists(){
        try{
            // Login utilisateur (compte root sans mot de passe)
            global $username;
            global $password;
            // Connexion à SQL
            $db = new PDO('mysql:host=localhost;port=8080', $username, $password);
            $sql="SHOW DATABASES LIKE 'CarSociety';";
            $donnees=$db->query($sql);
            if($donnees->rowCount()>0){
                $db=null;
                return true;
            }
            return false;    
        }
        catch(Exception $e){
            return false;
        }
    }

    ////////////////////////////////
    //////// LECTURE Users /////////
    ////////////////////////////////


    ////////////////////////////////
    //////// LECTURE Products //////
    ////////////////////////////////

    /*
    Lit le fichier products.xml et renvoie le tableau des produits associé (-1 si erreur)
    // Format du tableau :[catégorie => [[photo,référence,nom,prix,stock],...]]
    */
    function xml_to_array_products() {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file("../bdd/products.xml");

        if ($xml === false) {
            echo "Failed loading XML: ";
            return -1;
        } 
        else {
            $products = [];
            foreach ($xml->children() as $cat) {
                $products[$cat->getName()] = [];
                foreach($cat->children() as $car){
                    $tab = ["Image", "Référence", "Nom", "Prix", "Stock"];
                    $tab[0] = $car->img->__toString();
                    $tab[1] = $car->reference->__toString();
                    $tab[2] = $car->nom->__toString();
                    $tab[3] = (int) $car->prix;
                    $tab[4] = (int) $car->stock;
                    $products[$cat->getName()][] = $tab;
                }
            }
            return $products;
        }
    }

    /*
    Lit le fichier products.xml et ajoute les produits à la table SQL Products
    Renvoie un entier négatif si échec, 0 si
    */
    function xml_to_sql_products() {
        global $username;
        global $password;

        // Erreurs de connexion
        if(connect_db()===false){
            if(db_exists()===false){
                include 'CarSociety.php';
                if(connect_db()===false){
                    return -3;
                }
            }
            else{
                return -2;
            }
        }

        // Lecture XML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file("../bdd/products.xml");
        if ($xml === false) {
            echo "Failed loading XML: ";
            return -1;
        } 
        else {
            // Génération des INSERT
            try{
                $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety', $username, $password);
                foreach ($xml->children() as $cat) {
                    $products[$cat->getName()] = [];
                    foreach($cat->children() as $car){
                        $img = $car->img->__toString();
                        $ref = $car->reference->__toString();
                        $nom = $car->nom->__toString();
                        $prix = (int) $car->prix;
                        $stock = (int) $car->stock;
                        $categorie=$cat->getName();
                        $sql = "REPLACE INTO Products VALUES('$ref','$categorie','$nom',$prix,$stock,'$img');";
                        $db->exec($sql);
                    }
                }
                $db=null;
                return 0;
            }
            catch(Exception $e) {
                echo "Erreur: ".$e->getMessage()."<br/>";
                return -4;
            }
        }
    }

    ////////////////////////////////
    ////// MISE A JOUR Users ///////
    ////////////////////////////////


    ////////////////////////////////
    ////// MISE A JOUR Products/////
    ////////////////////////////////

?>
