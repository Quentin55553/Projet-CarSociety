<?php
    session_start();

    if (isset($_SESSION['email'])) {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page de profil
        header("Location: ../index.php");
        exit;
    }


    // On vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // On récupère les données du formulaire
        $lastname = strtoupper($_POST['lastname']);
        $firstname = ucfirst(strtolower($_POST['firstname']));
        $birth = $_POST['birth'];
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
            echo "<script>alert(\"Cet email est déjà utilisé. Veuillez réessayer.\")</script>";
        
        } else {
            // Nom du fichier JSON pour l'utilisateur
            $userJsonFile = str_replace("@", "_", $email) . '.json';
            // Chemin d'accès au fichier JSON pour l'utilisateur
            $userJsonPath = '../bdd/' . $userJsonFile;

            $userData = array(
                'lastname' => $lastname,
                'firstname' => $firstname,
                'birth' => $birth,
                'email' => $email,
                'tel' => $tel,
                'password' => $passwordHash
            );

             // Ajoute l'association email / chemin d'accès au fichier JSON dans le tableau des utilisateurs
            $users[$email] = $userJsonPath;

            // Enregistre le tableau des utilisateurs dans le fichier users.json
            file_put_contents($usersFile, json_encode($users));
            // Enregistre les données de l'utilisateur dans le fichier JSON correspondant
            file_put_contents($userJsonPath, json_encode($userData));

            $_SESSION['email'] = $email;

            header("Location: ../index.php");
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>


    <body>
        <a id="goUpButton"></a>

        <div class="header">
            <img src="../img/CarSocietyBanner.png">

            <div class="header-right">
                <a class="active" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                <a href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
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

            <div class="form-container">
                <form id="register-form" action="register.php" method="post">
                    <div class="input-group">
                        <label for="register-lastname">Nom</label>
                        <input type="text" id="register-lastname" name="lastname" required>
                    </div>

                    <div class="input-group">
                        <label for="register-firstname">Prénom</label>
                        <input type="text" id="register-firstname" name="firstname" required>
                    </div>

                    <div class="input-group">
                        <label for="register-birth">Date de naissance</label>
                        <input type="date" id="register-birth" name="birth" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="email" required>
                    </div>

                    <div class="input-group">
                        <label for="register-tel">Numéro de téléphone</label>
                        <input type="tel" id="register-tel" name="tel" pattern="0[1-9](\d{2}){4}" required>
                    </div>

                    <div class="input-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">S'inscrire</button>
                    </div>

                    <br><br>
                </form>
            </div>
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
