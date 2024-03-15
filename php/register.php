<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Création de compte</title>
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
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a href="urbancars.html"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="sedan.html"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="sportscars.html"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>

        <div class="content">
            <h1 class="main-title">Créer un compte</h1>

            <form id="register-form" action="register.php" method="post">
                <div class="input-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="register-password">Mot de passe</label>
                    <input type="password" id="register-password" name="password" required>
                </div>

                <div class="input-group">
                    <label for="register-password">Confirmer mot de passe</label>
                    <input type="password" id="register-password1" name="password_confirm" required>
                </div>

                <div class="center">
                    <button type="submit">S'inscrire</button>
                </div>
            </form>
        </div>

        <footer class="footer">
            <p>Copyright (c) 2024, CarSociety</p>
            <p>Tous droits réservés.</p>
        </footer>
    </body>
</html>
