<?php
    // SCRIPT POUR GERER LA BASE DE DONNEES DE CAR SOCIETY A PARTIR DES FICHIERS JSON ET XML
    // (COMPTE ROOT SANS MOT DE PASSE)

    ////////////////////////////////////////////////
    ////// CONNEXION A LA BASE DE DONNEES///////////
    ////////////////////////////////////////////////

    // Utilisateur SQL
    $username = "root";
    $password = "";
    
    // Cette condition a été rajoutée à cause de problèmes d'inclusions multiples
    if(!function_exists("connect_db")) {
        /*
        Cette fonction renvoie true si se connecter à la base de données est possible, false sinon
        */ 
        function connect_db() {
            try {
                // Login utilisateur (compte root sans mot de passe)
                global $username;
                global $password;
                // Connexion sur la base de données CarSociety
                $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety', $username, $password);
                $db = null;
                // Si pas d'erreur, true
                return true;
            
            }
            // Si erreur, false 
            catch (Exception $e) {
                return false;
            }    
        }


        /*
        Cette fonction renvoie true si la base de données existe, false sinon
        */ 
        function db_exists() {
            try {
                // Login utilisateur (compte root sans mot de passe)
                global $username;
                global $password;

                // Connexion à SQL
                $db = new PDO('mysql:host=localhost;port=8080', $username, $password);

                // Requête pour avoir la base de données
                $sql = "SHOW DATABASES LIKE 'CarSociety';";
                $donnees = $db->query($sql);

                // Si il y a pas 0 lignes en réponse, ça veut dire qu'elle existe,true
                if ($donnees->rowCount() > 0) {
                    $db = null;
                    return true;
                
                }
                // Sinon elle n'existe pas
                return false;    
            
            }
            // Cas d'erreur général, renvoi de faux
            catch (Exception $e) {
                return false;
            }
        }


        ////////////////////////////////
        //////// LECTURE Users /////////
        ////////////////////////////////

        /*
        La fonction lit le fichier users.json et ajoute chaque utilisateur à la table SQL Users
        Renvoie un entier négatif si échec, 0 si succès
        */
        function json_to_sql_users() {

            $json="../bdd/users.json";
            if (file_exists($json)) {

                // Login utilisateur (compte root sans mot de passe)
                global $username;
                global $password;
                
                // Différentes erreurs de connexion
                if (connect_db() === false) {
                    if (db_exists() === false) {
                        // Si la BDD n'existe pas, on essaye de l'initialiser avec le script spécial
                        include 'CarSociety.php';

                        // Si ça ne marche toujours pas, il y a vraiment un problème, renvoi d'un code d'erreur
                        if (connect_db() === false) {
                            return -3;
                        }
                    
                    }
                    // Si la BDD existe, il y a un problème
                    else {
                        return -2;
                    }
                }
                $yehe=file_get_contents($json);
                try {
                    // Connexion à la BDD
                    $db = new PDO('mysql:host=localhost;dbname=CarSociety', $username, $password);
    
                    //récupération des données utilisateurs
                    $donnees = json_decode($yehe, true);
    
                    // Parcours des utilisateurs
                    foreach ($donnees as $u => $infos) {
                        // Parcours des infos de l'utilisateur
                        $email= $u;
                        $id = strval($infos['client_number']);
                        $nom = $infos['lastname'];
                        $prenom = $infos['firstname'];
                        $ddn = $infos['birthdate'];
                        $tel = $infos['tel'];
                        $mdp = $infos['password'];
    
                        // On utilise "replace into" pour ne pas avoir d'erreur si l'utilisateur est déjà inséré
                        // Cela permet la mise à jour facile des données par simple appel de cette fonction si le json est à jour
                        $sql = "REPLACE INTO Users VALUES('$id', '$nom', '$prenom', '$ddn', '$email', '$tel', '$mdp');";
                        $db->exec($sql);
                    }
    
                    // Fermeture de la connexion
                    $db = null;
    
                    // Renvoi de la valeur de succès
                    return 0;
                }
                // Erreur inattendue
                catch (Exception $e) {
                    echo "Erreur : ".$e->getMessage()."<br/>";
                    return -4;
                }   
            }
            
            // Insertion des données dans la table SQL Products
            // Génération des INSERT
            
            try {
                // Connexion à la BDD
                $db = new PDO('mysql:host=localhost;dbname=CarSociety', $username, $password);

                //récupération des données utilisateurs
                $donnees = json_decode($yehe, true);

                // Parcours des utilisateurs
                foreach ($donnees as $u => $infos) {
                    // Parcours des infos de l'utilisateur
                    $email= $u;
                    $id = strval($infos['client_number']);
                    $nom = $infos['lastname'];
                    $prenom = $infos['firstname'];
                    $ddn = $infos['birthdate'];
                    $tel = $infos['tel'];
                    $mdp = $infos['password'];

                    // On utilise "replace into" pour ne pas avoir d'erreur si l'utilisateur est déjà inséré
                    // Cela permet la mise à jour facile des données par simple appel de cette fonction si le json est à jour
                    $sql = "REPLACE INTO Users VALUES('$id', '$nom', '$prenom', '$ddn', '$email', '$tel', '$mdp');";
                    $db->exec($sql);
                }

                // Fermeture de la connexion
                $db = null;

                // Renvoi de la valeur de succès
                return 0;
            }
            }
            // Erreur inattendue
            catch (Exception $e) {
                echo "Erreur : ".$e->getMessage()."<br/>";
                return -4;
            }    
        }


        ////////////////////////////////
        //////// LECTURE Products //////
        ////////////////////////////////

        /*
        Cette fonction lit le fichier products.xml et renvoie le tableau des produits associé (-1 si erreur)
        // Format du tableau : [catégorie ==> [[photo1,référence1,nom1,prix1,stock1],[photo2,référence2,nom2,prix2,stock2],...] ]
        */
        function xml_to_array_products() {
            // Paramètre de débuggage
            libxml_use_internal_errors(true);

            // Ouverture du fichier XML grâce aux méthodes de Simple XML Element
            $xml = simplexml_load_file("../bdd/products.xml");

            // Cas d'erreur
            if ($xml === false) {
                echo "Failed loading XML: ";
                return -1;
            
            } 
            // Lecture du fichier XML
            else {
                // Initialisation du tableau
                $products = [];
                // Parcours de toutes les catégories
                foreach ($xml->children() as $cat) {
                    // Nouvelle catégorie
                    $products[$cat->getName()] = [];
                    // Parcours de tous les produits de la catégorie
                    foreach($cat->children() as $car){
                        // Format des informations produits
                        $tab = ["Image", "Référence", "Nom", "Prix", "Stock"];
                        // Remplissage des informations avec des cast pour être sûr des types
                        // Lien image
                        $tab[0] = $car->img->__toString();
                        // Référence
                        $tab[1] = $car->reference->__toString();
                        // Nom
                        $tab[2] = $car->nom->__toString();
                        // Prix
                        $tab[3] = (int) $car->prix;
                        // Stock
                        $tab[4] = (int) $car->stock;
                        // Ajout du produit au tableau (avec la clé = catégorie courante)
                        $products[$cat->getName()][] = $tab;
                    }
                }
                // Renvoi du tableau final
                return $products;
            }
        }


        /*
        La fonction lit le fichier products.xml et ajoute chaque produit à la table SQL Products
        Renvoie un entier négatif si échec, 0 si succès
        */
        function xml_to_sql_products() {
            // Login utilisateur (compte root sans mot de passe)
            global $username;
            global $password;

            // Différentes erreurs de connexion
            if (connect_db() === false) {
                if (db_exists() === false) {
                    // Si la BDD n'existe pas, on essaye de l'initialiser avec le script spécial
                    include 'CarSociety.php';

                    // Si ça ne marche toujours pas, il y a vraiment un problème, renvoi d'un code d'erreur
                    if (connect_db() === false) {
                        return -3;
                    }
                
                }
                // Si la BDD existe, il y a un problème
                else {
                    return -2;
                }
            }

            // Lecture XML
            // Paramètre de débuggage
            libxml_use_internal_errors(true);

            // Ouverture du fichier XML grâce aux méthodes de Simple XML Element
            $xml = simplexml_load_file("../bdd/products.xml");

            // Cas d'erreur
            if ($xml === false) {
                echo "Failed loading XML: ";
                return -1;
            
            } 
            // Insertion des données dans la table SQL Products
            else {
                // Génération des INSERT
                try {
                    // Connexion à la BDD
                    $db = new PDO('mysql:host=localhost;port=8080;dbname=CarSociety', $username, $password);

                    // Parcours des catégories
                    foreach ($xml->children() as $cat) {
                        // Parcours des voitures de la catégorie
                        foreach ($cat->children() as $car) {
                            // Même données que dans xml_to_array_products()
                            $img = $car->img->__toString();
                            $ref = $car->reference->__toString();
                            $nom = $car->nom->__toString();
                            $prix = (int) $car->prix;
                            $stock = (int) $car->stock;

                            // On rajoute en plus la catégorie de la voiture en SQL
                            $categorie=$cat->getName();

                            // On utilise "replace into" pour ne pas avoir d'erreur si le produit est déjà inséré
                            // Cela permet la mise à jour facile des données par simple appel de cette fonction si le XML est à jour
                            $sql = "REPLACE INTO Products VALUES('$ref', '$categorie', '$nom', $prix, $stock, '$img');";
                            $db->exec($sql);
                        }
                    }

                    // Fermeture de la connexion
                    $db = null;

                    // Renvoi de la valeur de succès
                    return 0;
                
                }
                // Erreur inattendue
                catch (Exception $e) {
                    echo "Erreur : ".$e->getMessage()."<br/>";
                    return -4;
                }
            }
        }
    }
?>
