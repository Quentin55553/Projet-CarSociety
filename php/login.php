<?php
    session_start();

    if (isset($_GET['cat'])) {
        $catValue = $_GET['cat'];

        $message = "<div class='info-message'>
                        <div class='wrapper-failure'>
                            <div class='card'>
                                <div class='icon'><i class='fa fa-times-circle'></i></div>
                                <div class='subject'>
                                    <h3>Échec</h3>
                                    <p>Vous devez être connecté pour pouvoir effectuer cette action.</p>
                                </div>

                                <div class='icon-times'><i class='fas fa-times'></i></div>
                            </div>
                        </div>
                        <br>
                    </div>";

    } else {
        $catValue = null;
        $message = "";
    }

    if (isset($_SESSION['email'])) {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
        header("Location: ../index.php");
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usersFile = '../bdd/users.json';

        if (!file_exists($usersFile)) {
            // Si le fichier des utilisateurs n'existe pas, on affiche un message d'erreur
            $message = "<div class='info-message'>
                            <div class='wrapper-warning'>
                                <div class='card'>
                                    <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Attention</h3>
                                        <p>L'email ou le mot de passe est incorrect.</p>
                                    </div>

                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                        </div>";

        } else {
            $usersData = file_get_contents($usersFile);
            $users = json_decode($usersData, true);

            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Si l'email existe dans la liste des utilisateurs
            if (isset($users[$email])) {
                $userData = $users[$email];
                $passwordHash = $userData['password'];
                
                // Si le mot de passe est correct, on connecte l'utilisateur
                if (password_verify($password, $passwordHash)) {
                    // Mise à jour des informations de session
                    $_SESSION['email'] = $email;
                    $_SESSION['client_number'] = $userData['client_number'];
                    $_SESSION['lastname'] = $userData['lastname'];
                    $_SESSION['firstname'] = $userData['firstname'];
                    $_SESSION['birthdate'] = $userData['birthdate'];
                    $_SESSION['tel'] = $userData['tel'];

                    $_SESSION['just_connected'] = true;
                    
                    if (isset($catValue)) {
                        header("Location: .." . urldecode($catValue));
                        exit();
                    }

                    header("Location: ../index.php");
                    exit();

                } else {
                    // Si le mot de passe est incorrect, on affiche un message d'erreur
                    $message = "<div class='info-message'>
                                    <div class='wrapper-warning'>
                                        <div class='card'>
                                            <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                            <div class='subject'>
                                                <h3>Attention</h3>
                                                <p>L'email ou le mot de passe est incorrect.</p>
                                            </div>

                                            <div class='icon-times'><i class='fas fa-times'></i></div>
                                        </div>
                                    </div>
                                </div>";
                }

            } else {
                // Si l'email n'existe pas dans la liste des utilisateurs, on affiche un message d'erreur
                $message = "<div class='info-message'>
                                <div class='wrapper-warning'>
                                    <div class='card'>
                                        <div class='icon'><i class='fas fa-exclamation-circle'></i></div>
                                        <div class='subject'>
                                            <h3>Attention</h3>
                                            <p>L'email ou le mot de passe est incorrect.</p>
                                        </div>

                                        <div class='icon-times'><i class='fas fa-times'></i></div>
                                    </div>
                                </div>
                            </div>";
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
        <title>CarSociety - Connexion</title>
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
                <a class="in-menu" href="login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                <a class="active" href="register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>
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
            <h1 class="main-title">Se connecter</h1>

            <?php
                echo $message;
            ?>

            <div class="form-container">
                <form id="login-form" action="login.php<?php if(isset($_GET['cat'])) echo '?cat=' . urlencode($_GET['cat']); ?>" method="post">
                    <div class="input-group">
                        <label for="login-email"><i class="fas fa-at"></i> Email</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>

                    <div class="input-group">
                        <label for="login-password"><i class="fas fa-lock"></i> Mot de passe</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>

                    <div class="center">
                        <button class="red-button" type="submit">Se connecter</button>
                    </div>
                </form>

                <p class="text">Pas encore inscrit ?<a href="register.php" class="link">S'inscrire</a></p>
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
        <script src="../js/closeMessage.js"></script>
    </body>
</html>
