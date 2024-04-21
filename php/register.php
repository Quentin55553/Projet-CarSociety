<?php
    // Fonction pour générer un numéro de client unique
    function generateUniqueClientNumber($users) {
        do {
            // Génère un numéro de client à 10 chiffres aléatoirement
            $num_client = mt_rand(1000000000, 9999999999);
            // Vérifie si le numéro de client généré est déjà utilisé
            $exists = false;
            
            foreach ($users as $user) {
                if ($user['num_client'] == $num_client) {
                    $exists = true;
                    break;
                }
            }
        } while ($exists);

        return $num_client;
    }


    session_start();

    $message = "";

    if (isset($_SESSION['email'])) {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page de profil
        header("Location: ../index.php");
        exit;
    }

    $birthdate = (isset($_POST['birthdate']) && $_POST['birthdate'] !== "") ? $_POST['birthdate'] : date('Y-m-d', strtotime('+1 year'));
    $password = $_POST['password'] ?? null;

    // On inclue le script de vérification
    include 'checkData.php';

    // On vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($verificationsPassed) {
            $verificationsPassed = false;
            $errors = [];

            // On récupère les données du formulaire
            $lastname = strtoupper($_POST['lastname']);
            $firstname = ucfirst(strtolower($_POST['firstname']));
            $birthdate = $_POST['birthdate'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $password = $_POST['password'];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if (!file_exists('../bdd')) {
                // On crée le répertoire 'bdd' s'il n'existe pas
                mkdir('../bdd', 0777, true);
            }

            $usersFile = '../bdd/users.json';

            if (file_exists($usersFile)) {
                // Si le fichier users.json existe, on charge son contenu
                $usersData = file_get_contents($usersFile);
                $users = json_decode($usersData, true);

            } else {
                // On crée un tableau vide si le fichier n'existe pas
                $users = array();
            }

            // Si l'email est déjà utilisé, on affiche un message d'erreur
            if (isset($users[$email])) {
                $message = "<div class='info-message'>
                                <div class='wrapper-warning'>
                                    <div class='card'>
                                        <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                        <div class='subject'>
                                            <h3>Attention</h3>
                                            <p>Cet email est déjà utilisé. Veuillez réessayer.</p>
                                        </div>

                                        <div class='icon-times'><i class='fas fa-times'></i></div>
                                    </div>
                                </div>
                                <br>
                            </div>";
            
            } else {
                $client_num = generateUniqueClientNumber($users);

                $userData = array(
                    'client_number' => $client_num,
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                    'birthdate' => $birthdate,
                    'tel' => $tel,
                    'password' => $passwordHash
                );

                // Ajoute les données de l'utilisateur dans le tableau
                $users[$email] = $userData;

                // Enregistre les données de l'utilisateur dans le fichier users.json
                file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

                // Met à jour le mot de passe dans la bdd sql
                require_once 'CarSocietyData.php';
                json_to_sql_users();

                // Mise à jour des informations de session
                $_SESSION['email'] = $email;
                $_SESSION['client_number'] = $client_num;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['birthdate'] = $birthdate;
                $_SESSION['tel'] = $tel;

                $_SESSION['just_connected'] = true;

                header("Location: ../index.php");
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
        <title>CarSociety - Création de compte</title>
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
                <a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                <a class="in-menu" href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
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
            <h1 class="main-title">Créer un compte</h1>

            <?php
                echo $message;
            ?>

            <div class="form-container">
                <div class="text required-field">
                    <p class="required-field-star">*</p> 
                    <p>champs obligatoires</p>
                </div>

                <form id="register-form" action="register.php" method="post" novalidate>
                    <div class="input-group">
                        <label for="lastname" class="required"><i class="fas fa-user"></i> Nom</label>
                        <span id="lastname-error" class="error-message <?php echo isset($errors["lastname"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("lastname", $errors); ?>
                        </span>
                        <input type="text" id="lastname" name="lastname" minlength="3" maxlength="20" value="<?php echo isset($_POST["lastname"]) ? htmlspecialchars($_POST["lastname"]) : ""; ?>" <?php echo isset($errors["lastname"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="firstname" class="required"><i class="fas fa-user"></i> Prénom</label>
                        <span id="firstname-error" class="error-message <?php echo isset($errors["firstname"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("firstname", $errors); ?>
                        </span>
                        <input type="text" id="firstname" name="firstname" minlength="3" maxlength="20" value="<?php echo isset($_POST["firstname"]) ? htmlspecialchars($_POST["firstname"]) : ""; ?>" <?php echo isset($errors["firstname"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="birthdate" class="required"><i class="fas fa-calendar-alt"></i> Date de naissance</label>
                        <span id="birthdate-error" class="error-message <?php echo isset($errors["birthdate"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("birthdate", $errors); ?>
                        </span>
                        <input type="date" id="birthdate" name="birthdate" max="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_POST["birthdate"]) ? htmlspecialchars($_POST["birthdate"]) : ""; ?>" <?php echo isset($errors["birthdate"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="email" class="required"><i class="fas fa-envelope"></i> Email</label>
                        <span id="email-error" class="error-message <?php echo isset($errors["email"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("email", $errors); ?>
                        </span>
                        <input type="email" id="email" name="email" placeholder="email@exemple.com" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ""; ?>" <?php echo isset($errors["email"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="tel" class="required"><i class="fas fa-phone"></i> Numéro de téléphone</label>
                        <span id="tel-error" class="error-message <?php echo isset($errors["tel"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("tel", $errors); ?>
                        </span>
                        <input type="tel" id="tel" name="tel" pattern="0[1-9](\d{2}){4}" value="<?php echo isset($_POST["tel"]) ? htmlspecialchars($_POST["tel"]) : ""; ?>" <?php echo isset($errors["tel"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                    </div>

                    <div class="input-group">
                        <label for="password"><i class="fas fa-lock"></i> Mot de passe</label>
                        <span id="password-error" class="error-message <?php echo isset($errors["password"]) ? "with-content" : ""; ?>">
                            <?php displayErrors("password", $errors); ?>
                        </span>
                        <input type="password" id="password" name="password" <?php echo isset($errors["password"]) ? "style='color: white; background-color: #D3212CFF;'" : ""; ?> required>
                        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">S'inscrire</button>
                    </div>
                </form>

                <p class="text">Déjà inscrit ? <a href="login.php" class="link">Se connecter</a></p>
                <br><br>
            </div>
        </div>


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
