<?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $message = "";

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $options = '<a href="edit_profile.php"><i class="fas fa-user-cog"></i> Profil</a>
                    <a href="basket.php"><i class="fas fa-shopping-cart"></i> Panier</a>
                    <a class="active" href="logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';

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

        // Utilisation de PHPMailer pour envoyer l'email
        require "../PHPMailer/src/Exception.php";
        require "../PHPMailer/src/PHPMailer.php";
        require "../PHPMailer/src/SMTP.php";

        $mail = new PHPMailer(true);

        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'carsociety758@gmail.com';
        $mail->Password = 'nwxidkhvtxiwbnkq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuration de l'expéditeur et du destinataire
        $mail->setFrom('carsociety758@gmail.com', 'CarSociety');
        $mail->addAddress('serviceclientcarsociety@gmail.com', 'Service client CarSociety');

        // Ajout du sujet et du corps de l'email
        $mail->Subject = "Nouvelle demande de contact de $firstname $lastname";
        // On définit le format de l'email comme HTML
        $mail->isHTML(true);

        // Ajout de l'image du logo dans le mail
        $mail->AddEmbeddedImage('../img/CarSocietyLogo.png', 'carsocietylogo', 'CarSocietyLogo.png');

        $body = file_get_contents('../mail_text.html');
        $body = str_replace('{CONTACT_DATE}', $contact_date, $body);
        $body = str_replace('{LASTNAME}', $lastname, $body);
        $body = str_replace('{FIRSTNAME}', $firstname, $body);
        $body = str_replace('{EMAIL}', $email, $body);
        $body = str_replace('{GENDER}', $gender, $body);
        $body = str_replace('{BIRTHDATE}', $birthdate, $body);
        $body = str_replace('{JOB}', $job, $body);
        $body = str_replace('{OBJECT}', $object, $body);
        $body = str_replace('{CONTENT}', $content, $body);

        $mail->Body = $body;

        // Envoi de l'email
        if ($mail->send()) {
            $message = "<div class='info-message'>
                            <div class='wrapper-success'>
                                <div class='card'>
                                    <div class='icon'><i class='fas fa-check-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Succès</h3>
                                        <p>La demande de contact a été envoyée !</p>
                                    </div>
                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>";

        } else {
            $message = "<div class='info-message'>
                            <div class='wrapper-failure'>
                                <div class='card'>
                                    <div class='icon'><i class='fa fa-times-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Échec</h3>
                                        <p>La demande de contact n'a pas pu être envoyée.</p>
                                    </div>
                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>";
        }
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

            <?php
                echo $message;
            ?>

            <div class="info-message">
                <div class="wrapper-info">
                    <div class="card">
                        <div class="icon"><i class="fas fa-info-circle"></i></div>
                        <div class="subject">
                            <h3>Information</h3>
                            <p>La demande sera envoyée au service client.</p>
                        </div>

                        <div class="icon-times"><i class="fas fa-times"></i></div>
                    </div>
                </div>
                <br>
            </div>
            
            <div class="form-container">

                <div class="text required-field">
                    <p class="required-field-star">*</p> 
                    <p>champs obligatoires</p>
                </div>

                <form action="contact.php" method="post">
                    <div class="input-group">
                        <label for="contact_date" class="required">Date de contact</label>
                        <input type="date" id="contact_date" name="contact_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                
                    <div class="input-group">
                        <label for="lastname" class="required">Nom</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>

                    <div class="input-group">
                        <label for="firstname" class="required">Prénom</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>

                    <div class="input-group">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" required>
                    </div>
                    
                    <label class="required">Genre</label><br>
                    <input type="radio" id="man" name="gender" value="Homme" required>
                    <label for="man"><i class="fas fa-male" style="color: #3a8aceff;"></i> Homme</label>
                    <input type="radio" id="woman" name="gender" value="Femme" class="gender-option" required>
                    <label for="woman"><i class="fas fa-female" style="color: #e42d8cff;"></i> Femme</label><br>

                    <div class="input-group">
                        <label for="birthdate" class="required">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="job" class="required">Fonction</label>
                        <select name="job" id="job" required>
                            <option value="Ingénieur en informatique">Ingénieur en informatique</option>
                            <option value="Développeur de logiciels">Développeur de logiciels</option>
                            <option value="Analyste financier">Analyste financier</option>
                            <option value="Avocat">Avocat</option>
                            <option value="Comptable">Comptable</option>
                            <option value="Enseignant">Enseignant</option>
                            <option value="Médecin">Médecin</option>
                            <option value="Infirmier/infirmière">Infirmier/infirmière</option>
                            <option value="Architecte">Architecte</option>
                            <option value="Designer graphique">Designer graphique</option>
                            <option value="Marketing Manager">Marketing Manager</option>
                            <option value="Chef de projet">Chef de projet</option>
                            <option value="Analyste de données">Analyste de données</option>
                            <option value="Spécialiste des ressources humaines">Spécialiste des ressources humaines</option>
                            <option value="Consultant en gestion">Consultant en gestion</option>
                            <option value="Analyste en cybersécurité">Analyste en cybersécurité</option>
                            <option value="Écrivain/rédacteur">Écrivain/rédacteur</option>
                            <option value="Analyste de marché">Analyste de marché</option>
                            <option value="Technicien en maintenance">Technicien en maintenance</option>
                            <option value="Agent immobilier">Agent immobilier</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="object" class="required">Sujet</label>
                        <input type="text" id="object" name="object" maxlength="35" required>
                    </div>

                    <div class="input-group">
                        <label for="content" class="required">Contenu</label>
                        <textarea id="content" name="content" rows="4" cols="50" minlength="10" maxlength="500" placeholder="Contenu de votre demande" required></textarea>
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">Envoyer</button>
                    </div>
                </form>

                <br><br>
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
    <script src="../js/closeMessage.js"></script>
</html>
