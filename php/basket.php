<?php
session_start();
// Permet notamment d'avoir le tableau associatif des produits
require 'varSession.inc.php';

// Vérifie si une session avec l'email est déjà active
if (isset($_SESSION['email'])) {
    // Si une session est active, affiche le lien de déconnexion
    $options = '<a href="edit_profile.php"><i class="fas fa-user-cog"></i> Profil</a>
                <a class="in-menu" href="basket.php"><i class="fas fa-shopping-cart"></i> Panier</a>
                <a class="active" href="logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';

} 
else {
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion afin qu'il puisse se connecter pour accéder à son panier
    header("Location: set-need-connect.php?cat=" . urlencode("/php/basket.php"));
    exit;
}

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
            if ($reference==$produit[1]) {
                return $produit[3];
            }
        }
    }
}

/*
Cette fonction recherche le nom d'un article dans le tableau associatif des produits, elle le renvoie
Elle prend en paramètre la référence de l'objet recherché (string)
*/
function get_nom($reference) {
    // Utilisation du tableau des produits donné par varSession.inc.php
    global $products;
    // Parcours des produits en testant les références
    foreach ($products as $key => $value) {
        foreach ($value as $produit) {
            // Si les références correspondent, renvoi du nom
            if ($reference == $produit[1]) {
                return $produit[2];
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

/*
Cette fonction prend en paramètre un panier et créé un tableau HTML correspondant
$panier : tableau de la forme [[voiture1, qté], [voiture2,qté]....]
Elle ne renvoie rien
*/
function afficher_panier($panier) {
    // Utilisation du tableau des produits donné par varSession.inc.php
    global $products;

    // Headers de la table
    echo "<table class='tab-panier'>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                </tr>
            </thead>
        <tbody>";
    // Pour chaque élément du panier, ajout d'une ligne à la table
    foreach ($panier as $produit) {
        // Référence du produit
        $reference = $produit[0];
        echo "<tr>";
        // Colonne "Référence"
        echo "<td>".$reference."</td>";
        // Colonne "Nom"
        echo "<td>".get_nom($reference)."</td>";
        // Colonne "Prix"
        echo "<td>".get_prix($reference)." €</td>";
        // Colonne "Quantité"
        echo "<td>x".$produit[1]."</td>";
        echo "</tr>";
    }
    // Fin de la table
    echo "</tbody>
          </table>";
}
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Panier</title>
        <link rel="icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../js/products.js"></script>
    </head>


    <body>
        <a id="goUpButton"></a>


        <div class="header">
            <img src="../img/CarSocietyBanner.png">

            <div class="header-right">
                <?php echo $options; ?>
            </div>
        </div>
        

        <div class="menu">
            <div class="menu-header">MENU</div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Urbancars') ? 'active' : "" ; ?>" href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Sedans') ? 'active' : "" ; ?>" href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Sportscars') ? 'active' : "" ; ?>" href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>


        <div class="content">
            <h1 class="main-title">Votre panier</h1>

            <?php
                // Zone d'affichage du panier

                // Panier vide
                if($_SESSION['panier']==[]){
                    echo "<p> Votre panier est vide ! </p>";
                
                }
                // Panier non-vide 
                else {
                    echo "<p> Voici les véhicules ajoutés à votre panier : </p>";
                    // Table
                    afficher_panier($_SESSION['panier']);
                    // Affichage du prix total
                    echo "<p> Prix de la commande : ";
                    echo prix_total($_SESSION['panier']);
                    echo " €</p>";
                    // Bouton "Commander"
                    echo "<div class='center'>
                    <button class='red-button'>Commander</button></div>";
                }
            ?>
        </div>

        </br>
        
        <footer class="footer">
            <div class="legal-informations">
                <h2>CarSociety</h2>
                <p>Copyright (c) 2024, CarSociety</p>
                <p>Tous droits réservés</p>
            </div>

            <div class="networks">
                <h2>Nos réseaux</h2>
                <div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 				<a href="#"><i class="fab fa-linkedin-in"></i></a>
  	 			</div>
            </div>

            <div class="contact">
                <h2>Contact</h2>
                <p><i class="fas fa-envelope"></i> <a href="mailto:carsociety758@gmail.com">carsociety758@gmail.com</a></p>
                <p>Service client :</p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:serviceclientcarsociety@gmail.com">serviceclientcarsociety@gmail.com</a></p>
            </div>
        </footer>


        <script src="../js/goUpButton.js"></script>
    </body>
</html>
