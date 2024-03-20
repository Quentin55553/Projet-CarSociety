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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>


    <body>
        <a id="goUpButton"></a>

        <div class="header">
            <img src="../img/CarSocietyLogo.png">

            <div class="header-right">
                <a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-header">MENU</div>
            <a href="../index.html"><i class="fas fa-home"></i> Accueil</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Urbancars') ? 'active' : "" ; ?>" href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Sedans') ? 'active' : "" ; ?>" href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
            <a class="<?php echo (isset($_GET['cat']) && $_GET['cat'] == 'Sportscars') ? 'active' : "" ; ?>" href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>

        <?php
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
                <?php echo $title; ?>
            </h1>

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
                            require 'varSession.inc.php';

                            foreach ($produits[$_GET['cat']] as $voiture) {
                                echo "<tr>";
                                echo "<td><img src='../img/".$voiture[0]."'></td>";
                                echo "<td>".$voiture[1]."</td>";
                                echo "<td>".$voiture[2]."</td>";
                                echo "<td>".$voiture[3]."€</td>";
                                echo "<td class='invisible'>".$voiture[4]."</td>";
                                echo '<td><div class="commande"><button onclick="retrait_compteur('.$voiture[1].')">-</button><p id="'.$voiture[1].'">0</p><button onclick="ajout_compteur('.$voiture[1].')">+</button></div></br><button onclick="ajout_panier('.$voiture[1].')">Ajouter au panier</button></td>';
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>

                </br>

                <button id="stock-button" onclick="affichage_stock()">Afficher stock</button>

                </br></br></br>

                <?php else: ?>
                    <!-- Style à améliorer (menu qui apparaît lorsqu'un utilisateur est sur la page products.php (sans valeur de $_GET['cat'])) -->
                    <a href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
                    <a href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
                    <a href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
                <?php endif; ?>
        </div>

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
