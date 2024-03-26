<?php
    session_start();
    require 'CarSocietyData.php';
    // Format : catégorie ==> [[photo,référence,nom,prix,stock],...]
    $products = xml_to_array_products();

    // Insertion des produits dans la base de données SQL
    xml_to_sql_products();
?>
