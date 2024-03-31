<?php
session_start();
if($_GET['connected'] == 0){
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion afin qu'il puisse se connecter pour accéder à son panier
    echo -1;
}
else if($_GET['qte']==0){
    echo -2;
}
else if ($_GET['connected'] == 1){
    // Si une session est active, ajout au panier :

    // Demande du client 
    $ref=$_GET['ref'];
    $qte=$_GET['qte'];
    // Ajout au panier de session
    $ajout=false;
    foreach($_SESSION['panier'] as &$produit){
        if($produit[0]==$ref){
            $produit[1]=$produit[1]+$qte;
            $ajout=true;
        }
    }
    if($ajout==false){
        $_SESSION['panier'][]=[$ref,$qte];
    }
    
    // Modification du stock dans le fichier XML
    libxml_use_internal_errors(true);
    $xml = simplexml_load_file("../bdd/products.xml");
    if($xml === false) {
        return -1;
    } 
    else {
        foreach ($xml->children() as $cat) {
            foreach($cat->children() as $car){
                if($car->reference == $ref){
                    echo ((int) $car->stock) - $qte;
                    $car->stock = ((int) $car->stock) - $qte;
                }
            }
        }
    }
    $xml->asXML("../bdd/products.xml");
    // Cet appel sert à appeler les fonctions de mise à jour du tableau des produits et du SQL
    include "CarSocietyData.php";
} 
else {
    
    echo -3;
}

?>