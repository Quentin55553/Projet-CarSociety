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
                    <a href="basket.php"><i class="fas fa-shopping-cart"></i> Panier <strong>(<span id="total-basket">' . (isset($_SESSION['panier']) ? array_sum(array_column($_SESSION['panier'], 1)) : '0') . '</span>)</strong></a>
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

    $birthdate = (isset($_POST['birthdate']) && $_POST['birthdate'] !== "") ? $_POST['birthdate'] : date('Y-m-d', strtotime('+1 year'));
    $password = (isset($_POST['password']) && $_POST['password'] !== "") ? $_POST['password'] : null;
    $newPassword = (isset($_POST['new-password']) && $_POST['new-password'] !== "") ? $_POST['new-password'] : null;

    // On inclue le script de vérification
    include 'checkData.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($verificationsPassed) {
            // On récupère les données du formulaire
            $email = $_POST['email'];
            $lastname = strtoupper($_POST['lastname']);
            $firstname = ucfirst(strtolower($_POST['firstname']));
            $tel = $_POST['tel'];

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

            } else if ((empty($password) && !empty($newPassword)) || (!empty($password) && empty($newPassword))) {
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

            } else if (!empty($password) && !empty($newPassword)) {
                // Vérification du mot de passe actuel
                if ($password != $newPassword) {
                    if (password_verify($password, $userData["password"])) {
                        // Mise à jour des autres informations de l'utilisateur
                        $userData["lastname"] = $lastname;
                        $userData["firstname"] = $firstname;
                        $userData["birthdate"] = $birthdate;
                        $userData["tel"] = $tel;
                        $userData["password"] = password_hash($newPassword, PASSWORD_DEFAULT);

                        $users[$email] = $userData;

                        if ($email != $email_session) {
                            unset($users[$email_session]);
                        }

                        // Enregistre les données de l'utilisateur dans le fichier JSON 
                        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

                        // Met à jour le mot de passe dans la bdd sql
                        require_once '../bdd/CarSocietyData.php';
                        json_to_sql_users();


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

                // Met à jour le mot de passe dans la bdd sql
                require_once '../bdd/CarSocietyData.php';
                json_to_sql_users();

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

                <form action="edit_profile.php" method="post" novalidate>
                    <div class="input-group">
                        <label for="lastname" class="required"><i class="fas fa-user"></i> Nom</label>
                        <span id="lastname-error" class="error-message <?php echo isset($errors["lastname"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("lastname", $errors); ?>
                        </span>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $userData['lastname']; ?>" minlength="3" maxlength="20" <?php echo isset($errors["lastname"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="firstname" class="required"><i class="fas fa-user"></i> Prénom</label>
                        <span id="firstname-error" class="error-message <?php echo isset($errors["firstname"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("firstname", $errors); ?>
                        </span>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $userData['firstname']; ?>" minlength="3" maxlength="20" <?php echo isset($errors["firstname"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="birthdate" class="required"><i class="fas fa-calendar-alt"></i> Date de naissance</label>
                        <span id="birthdate-error" class="error-message <?php echo isset($errors["birthdate"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("birthdate", $errors); ?>
                        </span>
                        <input type="date" id="birthdate" name="birthdate" value="<?php echo $userData['birthdate']; ?>" max="<?php echo date('Y-m-d'); ?>" <?php echo isset($errors["birthdate"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="email" class="required"><i class="fas fa-envelope"></i> Email</label>
                        <span id="email-error" class="error-message <?php echo isset($errors["email"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("email", $errors); ?>
                        </span>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" value="<?php echo $email_session; ?>" <?php echo isset($errors["email"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="tel" class="required"><i class="fas fa-phone"></i> Numéro de téléphone</label>
                        <span id="tel-error" class="error-message <?php echo isset($errors["tel"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("tel", $errors); ?>
                        </span>
                        <input type="tel" id="tel" name="tel" pattern="0[1-9](\d{2}){4}" value="<?php echo $userData['tel']; ?>" <?php echo isset($errors["tel"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="client-number"><i class="fas fa-id-card"></i> Numéro de client</label>
                        <input type="text" id="client-number" name="client-number" pattern="\d{10}" value="<?php echo $userData['client_number']; ?>" required readonly>
                    </div>

                    <div class="input-group">
                        <label for="password"><i class="fas fa-lock"></i> Mot de passe actuel</label>
                        <span id="password-error" class="error-message <?php echo isset($errors["password"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("password", $errors); ?>
                        </span>
                        <input type="password" id="password" name="password" <?php echo isset($errors["password"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?>>
                        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                    </div>

                    <div class="input-group">
                        <label for="new-password"><i class="fas fa-lock"></i> Nouveau mot de passe</label>
                        <span id="new-password-error" class="error-message <?php echo isset($errors["new-password"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("new-password", $errors); ?>
                        </span>
                        <input type="password" id="new-password" name="new-password" <?php echo isset($errors["new-password"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?>>
                        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
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
                <img src="../img/CarSocietyLogo.png">
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
        <script src="../js/passwordButton.js"></script>
        <script src="../js/checkForm.js"></script>
    </body>
</html>
