<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Accueil</title>
        <link rel="icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="../js/produits.js"></script>
    </head>


    <body>
        <div class="header">
            <img src="../img/CarSocietyLogo.png">

            <div class="header-right">
                <a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-header">MENU</div>
            <a class="active" href="../index.html"><i class="fas fa-home"></i> Accueil</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos véhicules</div>
            <a href="produits.php?cat=Citadines"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="produits.php?cat=Berlines"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="produits.php?cat=Sportives"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>

        <div class="content">
            <h1 class="main-title">
                <?php echo $_GET['cat'];?>
            </h1>

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
                    foreach($produits[$_GET['cat']] as $voiture){
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
            </br> </br> </br>
        </div>

        <footer class="footer">
            <p>Copyright (c) 2024, CarSociety</p>
            <p>Tous droits réservés.</p>
        </footer>
    </body>
</html>
