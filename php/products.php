<?php
    session_start();
    // Permet notamment d'avoir le tableau associatif des produits
    require 'varSession.inc.php';
    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $options = '<a href="edit_profile.php"><i class="fas fa-user-cog"></i> Profil</a>
                    <a href="basket.php"><i class="fas fa-shopping-cart"></i> Panier</a>
                    <a class="active" href="logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';
        // Variable de vérification de connexion
        $connected=1;
    } 
    else {
        // Si aucune session n'est active, affiche les liens de connexion et de création de compte
        $options = '<a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                    <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>';
        // Variable de vérification de connexion
        $connected=0;
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Produits</title>
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

        <?php
            // Préparation du titre en fonction de la catégorie (argument GET)
            $cat = $_GET['cat'];
            $title = "";
            
            switch ($cat) {
                case "Sportscars":
                    $title = "Voitures de sport";
                    break;

                case "Sedans":
                    $title = "Berlines";
                    break;

                case "Urbancars":
                    $title = "Citadines";
                    break;

                default:
                    $title = "Nos produits";
                    break;
            }
        ?>

        <div class="content">
            <h1 class="main-title">
                <?php 
                    echo $title; // Affichage du titre
                ?>
            </h1>
            <div id="annonceur"></div>
            <?php if ($title !== "Nos produits"): ?>
                <table class="tab">
                    <thead>
                        <tr>
                            <th>Visuel</th>
                            <th>Référence</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th class="invisible">Stock</th>
                            <th>Commande</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Zone d'affichage du tableau HTML des produits

                            // Parcours des produits de la catégorie passée en GET dans le tableau associatif $products
                            foreach ($products[$_GET['cat']] as $voiture) {
                                // Nouvelle ligne de la table
                                echo "<tr>";
                                // Colonne "Visuel"
                                echo "<td>
                                        <img src='../img/".$voiture[0]."'>
                                    </td>";
                                // Colonne "Référence"
                                echo "<td>".$voiture[1]."</td>";
                                // Colonne "Nom"
                                echo "<td>".$voiture[2]."</td>";
                                // Colonne "Prix"
                                echo "<td>".$voiture[3]." €</td>";
                                // Colonne "Stock" (avec l'identification nécessaire pour le javascript)
                                echo "<td class='invisible' id='stock-".$voiture[1]."'>".$voiture[4]."</td>";
                                // Colonne "Commande" :
                                // 1) Bouton "-" pour retirer une unité au compteur
                                // 2) Element <p> qui contient la quantité à ajouter au panier
                                // 3) Bouton "+" pour ajouter une unité au compteur
                                // 4) Bouton "Ajouter au panier
                                echo '<td>
                                        <div class="commande">
                                            <button onclick="retrait_compteur('.$voiture[1].')">
                                                <i class="fas fa-minus-circle"></i>
                                            </button>

                                            <p id="'.$voiture[1].'">0</p>
                                            
                                            <button onclick="ajout_compteur('.$voiture[1].')">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </div>
                                        </br>
                                        
                                        <button onclick="ajout_panier('.$voiture[1].','.$connected.')">Ajouter au panier</button>
                                    </td>';
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>

                <div class="center">
                    <button class="red-button" id="stock-button" onclick="affichage_stock()">Afficher stock</button>
                </div>

                </br></br>

                <?php else: ?>
                    <!-- Style à améliorer (menu qui apparaît lorsqu'un utilisateur est sur la page products.php (sans valeur de $_GET['cat'])) -->
                    <a href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
                    <a href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
                    <a href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
                <?php endif; ?>
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
        <script src="../js/closeMessage.js"></script>
    </body>
</html>
