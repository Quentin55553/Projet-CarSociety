<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $options = '<a class="active" href="logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';

    } else {
        // Si aucune session n'est active, affiche les liens de connexion et de création de compte
        $options = '<a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                    <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>';
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contact_date = $_POST['contact_date'];
        $lastname = strtoupper($_POST['lastname']);
        $firstname = ucfirst(strtolower($_POST['firstname']));
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];
        $job = $_POST['job'];
        $object = $_POST['object'];
        $content = $_POST['content'];


        // Envoi de l'email de validation à l'adresse email indiquée
        $receiver = "serviceclientcarsociety@gmail.com";
        $subject = "Nouvelle demande de contact de $firstname $lastname";

        $body = file_get_contents('../mail_text.txt');

        $body = str_replace('{CONTACT_DATE}', $contact_date, $body);
        $body = str_replace('{LASTNAME}', $lastname, $body);
        $body = str_replace('{FIRSTNAME}', $firstname, $body);

        $body = str_replace('{EMAIL}', $email, $body);
        $body = str_replace('{GENDER}', $gender, $body);
        $body = str_replace('{BIRTHDATE}', $birthdate, $body);
        $body = str_replace('{JOB}', $job, $body);
        $body = str_replace('{OBJECT}', $object, $body);
        $body = str_replace('{CONTENT}', $content, $body);
    
        $sender = "From: CarSociety";

        // Envoi de l'email
        if (mail($receiver, $subject, $body, $sender)) {
            echo "<script>alert(\"Email envoyé avec succès à : $receiver\")</script>";

        } else {
            echo "<script>alert(\"Echec lors de l'envoi du mail !\")</script>";
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
            <img src="../img/CarSocietyBanner.png">

            <div class="header-right">
                <?php echo $options; ?>
            </div>
        </div>

        <div class="menu">
            <div class="menu-header">MENU</div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
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
                        <label for="contact_date">Date de contact</label>
                        <input type="date" id="contact_date" name="contact_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                
                    <div class="input-group">
                        <label for="lastname">Nom</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>

                    <div class="input-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" required>
                    </div>
                    
                    <label>Genre</label><br>
                    <input type="radio" id="man" name="gender" value="Homme" required>
                    <label for="man"><i class="fas fa-male" style="color: #3a8aceff;"></i> Homme</label>
                    <input type="radio" id="woman" name="gender" value="Femme" class="gender-option" required>
                    <label for="woman"><i class="fas fa-female" style="color: #e42d8cff;"></i> Femme</label><br>

                    <div class="input-group">
                        <label for="birthdate">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="job">Fonction</label>
                        <select name="job" id="job" required>
                            <option value="A déterminer">A déterminer</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="object">Sujet</label>
                        <input type="text" id="object" name="object" maxlength="35" required>
                    </div>

                    <div class="input-group">
                        <label for="content">Contenu</label>
                        <textarea id="content" name="content" rows="4" cols="50" maxlength="500" placeholder="Contenu de votre demande" required></textarea>
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
