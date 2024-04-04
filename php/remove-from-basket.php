<?php
    session_start();

    // Permet notamment d'avoir le tableau associatif des produits
    require_once 'varSession.inc.php';


    /*
    Cette fonction recherche le prix d'un article dans le tableau associatif des produits, elle le renvoie
    Elle prend en paramètre la référence de l'objet recherché (string)
    */
    function get_prix($reference){
        // Utilisation du tableau des produits donné par varSession.inc.php
        global $products;

        // Parcours des produits en testant les références
        foreach ($products as $key => $value) {
            foreach ($value as $produit) {
                // Si les références correspondent, renvoi du prix
                if ($reference == $produit[1]) {
                    return $produit[3];
                }
            }
        }
    }


    /*
    Cette fonction prend en paramètre un panier et renvoi le prix total des articles présents
    $panier : tableau de la forme [[voiture1, qté], [voiture2,qté]....]
    */
    function prix_total($panier) {
        // Prix total
        $prix = 0;

        // Parcours des produits du panier
        foreach ($panier as $produit) {
            // Ajout du prix * quantité pour chaque article
            $prix = $prix + (get_prix($produit[0]) * $produit[1]);
        }

        // Renvoi du prix total
        return $prix;
    }


    // Si l'utilisateur est connecté, démarrage de la procédure
    if (isset($_GET['qte']) && isset($_GET['ref'])){
        // Demande du client 
        $ref = $_GET['ref'];
        $qte = $_GET['qte'];
        
        // Retrait du panier de session
        $paniertemp = [];

        foreach ($_SESSION['panier'] as &$produit) {
            if ($produit[0] != $ref) {
                $paniertemp[] = $produit;
            }
        }

        $_SESSION['panier'] = $paniertemp;

        // Modification du stock dans le fichier XML
        libxml_use_internal_errors(true);

        // Chargement du fichier des produits
        $xml = simplexml_load_file("../bdd/products.xml");

        // Cas d'erreur
        if ($xml === false) {
            echo -3;
        
        }
        // Modifications
        else {
            // Recherche du produit qui a la bonne référence dans le fichier
            foreach ($xml->children() as $cat) {
                foreach ($cat->children() as $car) {
                    // Test d'égalité des références
                    if ($car->reference == $ref) {
                        // Mise à jour du stock dans l'arborescence XML
                        $car->stock = ((int) $car->stock) + $qte;
                        // Renvoi du nouveau prix total
                        echo number_format(prix_total($_SESSION['panier'], 0, '.', ' '));
                    }
                }
            }
            // Sauvegarde des modifications dans le fichier XML
            $xml->asXML("../bdd/products.xml");

            // Cet appel sert à appeler les fonctions de mise à jour du tableau associatif des produits et du SQL (qui se font à partir du XML désormais à jour)
            include "varSession.inc.php";
        }
    
    } 
    // Autres cas : renvoi de -3 pour un affichage d'erreur
    else {  
        echo -3;
    }
?>
