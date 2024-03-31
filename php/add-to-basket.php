<?php
session_start();
// Si l'utilisateur n'est pas connecté, renvoi de -1 pour un affichage d'erreur
if($_GET['connected'] == 0){
    echo -1;
}
// Si l'utilisateur essaye d'ajouter 0 produit, renvoi de -2 pour un affichage d'erreur
else if($_GET['qte']==0){
    echo -2;
}
// Si l'utilisateur est connecté, démarrage de la procédure
else if ($_GET['connected'] == 1){

    // Demande du client 
    $ref=$_GET['ref'];
    $qte=$_GET['qte'];

    // Ajout au panier de session
    $ajout=false;
    // On regarde d'abord s'il y a déjà un produit du même type dans le panier, si oui il faut juste mettre à jour la quantité
    foreach($_SESSION['panier'] as &$produit){
        if($produit[0]==$ref){
            $produit[1]=$produit[1]+$qte;
            $ajout=true;
        }
    }
    // Si le produit n'est pas déjà présent, ajout d'un item au panier
    if($ajout==false){
        $_SESSION['panier'][]=[$ref,$qte];
    }
    
    // Modification du stock dans le fichier XML
    libxml_use_internal_errors(true);
    // Chargement du fichier des produits
    $xml = simplexml_load_file("../bdd/products.xml");
    // Cas d'erreur
    if($xml === false) {
        return -1;
    } 
    // Modifications
    else {
        // Recherche du produit qui a la bonne référence dans le fichier
        foreach ($xml->children() as $cat) {
            foreach($cat->children() as $car){
                // Test d'égalité des référence
                if($car->reference == $ref){
                    // Renvoi du stock mis à jour à l'objet XMLHttpRequest
                    echo ((int) $car->stock) - $qte;
                    // Mise à jour du stock dans l'arborescence XML
                    $car->stock = ((int) $car->stock) - $qte;
                }
            }
        }
    }
    // Sauvegarde des modifications dans le fichier XML
    $xml->asXML("../bdd/products.xml");
    // Cet appel sert à appeler les fonctions de mise à jour du tableau associatif des produits et du SQL (qui se font à partir du XML désormais à jour)
    include "CarSocietyData.php";
} 
// Autres cas : renvoi de -3 pour un affichage d'erreur
else {  
    echo -3;
}

?>