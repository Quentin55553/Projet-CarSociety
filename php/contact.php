<?php
    // Code ici
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Contact</title>
        <link rel="icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <a href="../index.html"><i class="fas fa-home"></i> Accueil</a>
            <a class="active" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a href="urbancars.html"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="sedan.html"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="sportscars.html"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>

        <div class="content">
            <h1 class="main-title">Demande de contact</h1>

            <form action="contact.php" method="post">
                <label for="date_contact">Date de contact :</label><br>
                <input type="date" id="date_contact" name="date_contact"><br>
                
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom"><br>
                
                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom"><br>
                
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email"><br>
                
                <label>Genre :</label><br>
                <input type="radio" id="homme" name="genre" value="homme">
                <label for="homme">Homme</label>
                <input type="radio" id="femme" name="genre" value="femme">
                <label for="femme">Femme</label><br>
                
                <label for="date_naissance">Date de naissance :</label><br>
                <input type="date" id="date_naissance" name="date_naissance"><br>
                
                <label for="fonction">Fonction :</label><br>
                <input type="text" id="fonction" name="fonction"><br>
                
                <label for="sujet">Sujet :</label><br>
                <input type="text" id="sujet" name="sujet"><br>
                
                <label for="contenu">Contenu :</label><br>
                <textarea id="contenu" name="contenu" rows="4" cols="50"></textarea><br>
                
                <input type="submit" value="Envoyer">
            </form>
        </div>

        <footer class="footer">
            <p>Copyright, mentions légales</p>
        </footer>
    </body>
</html>
