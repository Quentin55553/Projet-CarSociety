<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date_contact = $_POST['date_contact'];
        $nom = strtoupper($_POST['nom']);
        $prenom = ucfirst(strtolower($_POST['prenom']));
        $email = $_POST['email'];
        $genre = $_POST['genre'];
        $date_naissance = $_POST['date_naissance'];
        $fonction = $_POST['fonction'];
        $sujet = $_POST['sujet'];
        $contenu = $_POST['contenu'];


        // Envoi de l'email de validation à l'adresse email indiquée
        $receiver = "serviceclientcarsociety@gmail.com";
        $subject = "Nouvelle demande de contact de $prenom $nom";

        $body = file_get_contents('../mail_text.txt');

        $body = str_replace('{CONTACT_DATE}', $date_contact, $body);
        $body = str_replace('{LASTNAME}', $nom, $body);
        $body = str_replace('{FIRSTNAME}', $prenom, $body);

        $body = str_replace('{EMAIL}', $email, $body);
        $body = str_replace('{GENDER}', $genre, $body);
        $body = str_replace('{BIRTHDATE}', $date_naissance, $body);
        $body = str_replace('{JOB}', $fonction, $body);
        $body = str_replace('{OBJECT}', $sujet, $body);
        $body = str_replace('{CONTENT}', $contenu, $body);
    
        $sender = "From: CarSociety";

        // Envoi de l'email
        if (mail($receiver, $subject, $body, $sender)) {
            echo "Email envoyé avec succès à : $receiver";
        } else {
            echo "Echec lors de l'envoi du mail !";
        }

        exit();
    }
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
            <a class="active" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>

        <div class="content">
            <h1 class="main-title">Demande de contact</h1>
            
            <div class="form-container">
                <form action="contact.php" method="post">
                    <div class="input-group">
                        <label for="date_contact">Date de contact</label>
                        <input type="date" id="date_contact" name="date_contact" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                
                    <div class="input-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>

                    <div class="input-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" required>
                    </div>
                    
                    <label>Genre</label><br>
                    <input type="radio" id="homme" name="genre" value="Homme" required>
                    <label for="homme"><i class="fas fa-male" style="color: #3a8aceff;"></i> Homme</label>
                    <input type="radio" id="femme" name="genre" value="Femme" class="gender-option" required>
                    <label for="femme"><i class="fas fa-female" style="color: #e42d8cff;"></i> Femme</label><br>

                    <div class="input-group">
                        <label for="date_naissance">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="fonction">Fonction</label>
                        <select name="fonction" id="fonction" required>
                            <option value="A déterminer">A déterminer</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="sujet">Sujet</label>
                        <input type="text" id="sujet" name="sujet" maxlength="35" required>
                    </div>

                    <div class="input-group">
                        <label for="contenu">Contenu</label>
                        <textarea id="contenu" name="contenu" rows="4" cols="50" maxlength="500" placeholder="Contenu de votre demande" required></textarea>
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>

        <br>

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
    </body>

    <script src="../js/goUpButton.js"></script>
</html>
