<?php
    session_start();

    if (isset($_SESSION['changes_confirmed'])) {
        $message =  "<div class='info-message'>
                        <div class='wrapper-success'>
                            <div class='card'>
                                <div class='icon'><i class='fas fa-check-circle'></i></div>
                                <div class='subject'>
                                    <h3>Confirmation</h3>
                                    <p>Les changement ont été effectués avec succès !</p>
                                </div>

                                <div class='icon-times'><i class='fas fa-times'></i></div>
                            </div>
                        </div>
                        <br>
                    </div>";

        unset($_SESSION['changes_confirmed']);

    } else {
        $message = "";
    }

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $options = '<a class="in-menu" href="edit_profile.php"><i class="fas fa-user-cog"></i> Profil</a>
                    <a href="basket.php"><i class="fas fa-shopping-cart"></i> Panier</a>
                    <a class="active" href="logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';

    } else {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion pour qu'il puisse accéder à son profil
        header("Location: set-need-connect.php?cat=" . urlencode("/php/edit_profile.php"));
        exit();
    }

    // On récupére les informations de l'utilisateur courant
    $email_session = $_SESSION['email'];
    $usersFile = '../bdd/users.json';
    $data = file_get_contents($usersFile);
    $users = json_decode($data, true);
    $userData = $users[$email_session];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // On récupère les données du formulaire
        $email = $_POST['email'];
        $lastname = strtoupper($_POST['lastname']);
        $firstname = ucfirst(strtolower($_POST['firstname']));
        $birthdate = $_POST['birthdate'];
        $tel = $_POST['tel'];
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];

        // Vérifie si le nouveau mail n'est pas déjà associé à un compte
        if (($email != $email_session) && (isset($users[$email]))) {
            $message = "<div class='info-message'>
                            <div class='wrapper-warning'>
                                <div class='card'>
                                    <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Attention</h3>
                                        <p>Cet e-mail est déjà associé à un compte.</p>
                                    </div>

                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>";

        } else if ((empty($current_password) && !empty($new_password)) || (!empty($current_password) && empty($new_password))) {
            $message = "<div class='info-message'>
                            <div class='wrapper-warning'>
                                <div class='card'>
                                    <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Attention</h3>
                                        <p>Le changement de mot de passe requiert le mot de passe actuel ainsi que le nouveau.</p>
                                    </div>

                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>";

        } else if (!empty($current_password) && !empty($new_password)) {
            // Vérification du mot de passe actuel
            if ($current_password != $new_password) {
                if (password_verify($current_password, $userData["password"])) {
                    // Mise à jour des autres informations de l'utilisateur
                    $userData["lastname"] = $lastname;
                    $userData["firstname"] = $firstname;
                    $userData["birthdate"] = $birthdate;
                    $userData["tel"] = $tel;
                    $userData["password"] = password_hash($new_password, PASSWORD_DEFAULT);

                    $users[$email] = $userData;

                    if ($email != $email_session) {
                        unset($users[$email_session]);
                    }

                    // Enregistre les données de l'utilisateur dans le fichier JSON 
                    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

                    // Mise à jour des informations de session
                    $_SESSION["email"] = $email;
                    $_SESSION["lastname"] = $lastname;
                    $_SESSION["firstname"] = $firstname;
                    $_SESSION["birthdate"] = $birthdate;
                    $_SESSION["tel"] = $tel;

                    $_SESSION['changes_confirmed'] = true;

                    header("Location: edit_profile.php");
                    exit();

                } else {
                    $message = "<div class='info-message'>
                                    <div class='wrapper-warning'>
                                        <div class='card'>
                                            <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                            <div class='subject'>
                                                <h3>Attention</h3>
                                                <p>Le mot de passe actuel rentré est incorrect.</p>
                                            </div>

                                            <div class='icon-times'><i class='fas fa-times'></i></div>
                                        </div>
                                    </div>
                                    <br>
                                </div>";
                }

            } else {
                $message = "<div class='info-message'>
                                <div class='wrapper-warning'>
                                    <div class='card'>
                                        <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                        <div class='subject'>
                                            <h3>Attention</h3>
                                            <p>Le nouveau mot de passe doit être différent de l'ancien.</p>
                                        </div>

                                        <div class='icon-times'><i class='fas fa-times'></i></div>
                                    </div>
                                </div>
                                <br>
                            </div>";
            }

        // Si l'utilisateur souhaite modifier ses informations personnelles mais pas le mot de passe
        } else {
            // Mise à jour des autres informations de l'utilisateur
            $userData["lastname"] = $lastname;
            $userData["firstname"] = $firstname;
            $userData["birthdate"] = $birthdate;
            $userData["tel"] = $tel;

            $users[$email] = $userData;

            if ($email != $email_session) {
                unset($users[$email_session]);
            }

            // Enregistre les données de l'utilisateur dans le fichier JSON 
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

            // Mise à jour des informations de session
            $_SESSION["email"] = $email;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["birthdate"] = $birthdate;
            $_SESSION["tel"] = $tel;

            $_SESSION['changes_confirmed'] = true;

            header("Location: edit_profile.php");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Profil</title>
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
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a href="products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>


        <div class="content">
            <h1 class="main-title">Votre profil</h1>

            <?php
                echo $message;
            ?>
            
            <div class="form-container">
                <div class="text required-field">
                    <p class="required-field-star">*</p> 
                    <p>champs obligatoires</p>
                </div>

                <form action="edit_profile.php" method="post">
                    <div class="input-group">
                        <label for="lastname" class="required">Nom</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $userData['lastname']; ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="firstname" class="required">Prénom</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $userData['firstname']; ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="birthdate" class="required">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate" value="<?php echo $userData['birthdate']; ?>" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" value="<?php echo $email_session; ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="register-tel" class="required">Numéro de téléphone</label>
                        <input type="tel" id="register-tel" name="tel" pattern="0[1-9](\d{2}){4}" value="<?php echo $userData['tel']; ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="client-number">Numéro de client</label>
                        <input type="text" id="client-number" name="client-number" pattern="\d{10}" value="<?php echo $userData['client_number']; ?>" required readonly>
                    </div>

                    <div class="input-group">
                        <label for="current-password">Mot de passe actuel</label>
                        <input type="password" id="current-password" name="current-password">
                    </div>

                    <div class="input-group">
                        <label for="new-password">Nouveau mot de passe</label>
                        <input type="password" id="new-password" name="new-password">
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

        <br><br>

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
