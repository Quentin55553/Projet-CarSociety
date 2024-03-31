<?php
require 'CarSocietyData.php';
// Insertion des produits dans un tableau associatif
// Format : catégorie ==> [[photo,référence,nom,prix,stock],...]
$products = xml_to_array_products();

// Insertion des produits dans la base de données SQL
xml_to_sql_products();
?>
