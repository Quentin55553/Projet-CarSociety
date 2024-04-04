<?php
    // Script PHP permettant de gérer diverses création et mises à jour de données

    // Inclusion des fonction à utiliser
    require_once 'CarSocietyData.php';

    // Insertion des produits dans un tableau associatif
    // Format du tableau : [catégorie ==> [[photo1,référence1,nom1,prix1,stock1],[photo2,référence2,nom2,prix2,stock2],...] ]
    $products = xml_to_array_products();

    // Insertion des produits dans la base de données SQL
    xml_to_sql_products();
?>
