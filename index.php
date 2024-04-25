<?php
    session_start();

    if (isset($_SESSION['just_connected'])) {
        $message = "<div class='info-message'>
                        <div class='wrapper-success'>
                            <div class='card'>
                                <div class='icon'><i class='fas fa-check-circle'></i></div>
                                <div class='subject'>
                                    <h3>Bonjour "; 
                                    
        $message .= $_SESSION['firstname']; 
        $message .= "</h3>
                        <p>Vous êtes désormais connecté à votre compte.</p>
                    </div>

                    <div class='icon-times'><i class='fas fa-times'></i></div>
                </div>
            </div>
            <br>
        </div>";

        unset($_SESSION['just_connected']);

    } else if (isset($_SESSION['just_ordered'])) {
        $message = "<div class='info-message'>
                        <div class='wrapper-success'>
                            <div class='card'>
                                <div class='icon'><i class='fas fa-check-circle'></i></div>
                                <div class='subject'>
                                    <h3>Merci "; 
                                    
        $message .= $_SESSION['firstname']; 
        $message .= "</h3>
                        <p>d'avoir commandé chez nous ! Nous vous livrerons dès que possible.</p>
                    </div>

                    <div class='icon-times'><i class='fas fa-times'></i></div>
                </div>
            </div>
            <br>
        </div>";

        unset($_SESSION['just_oredered']);
    } else {
        $message = "";
    }

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $options = '<a href="php/edit_profile.php"><i class="fas fa-user-cog"></i> Profil</a>
                    <a href="php/basket.php"><i class="fas fa-shopping-cart"></i> Panier <strong>(<span id="total-basket">' . (isset($_SESSION['panier']) ? array_sum(array_column($_SESSION['panier'], 1)) : '0') . '</span>)</strong></a>
                    <a class="active" href="php/logout.php"><i class="fas fa-sign-in-alt"></i> Se déconnecter</a>';

    } else {
        // Si aucune session n'est active, affiche les liens de connexion et de création de compte
        $options = '<a class="active" href="php/login.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                    <a href="php/register.php"><i class="fas fa-user-plus"></i> Créer un compte</a>';
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarSociety - Accueil</title>
        <link rel="icon" href="img/favicon.ico">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>


    <body>
        <a id="goUpButton"></a>


        <div class="header">
            <img src="img/CarSocietyBanner.png">

            <div class="header-right">
                <?php echo $options; ?>
            </div>
        </div>
        

        <div class="menu">
            <div class="menu-header">MENU</div>
            <a class="active" href="index.php"><i class="fas fa-home"></i> Accueil</a>
            <a href="php/contact.php"><i class="fas fa-envelope"></i> Contact</a>

            <hr>

            <div class="menu-header">Nos produits</div>
            <a href="php/products.php?cat=Urbancars"><i class="fas fa-car-side"></i> Citadines</a>
            <a href="php/products.php?cat=Sedans"><i class="fas fa-car-alt"></i> Berlines</a>
            <a href="php/products.php?cat=Sportscars"><i class="fas fa-flag-checkered"></i> Sportives</a>
        </div>


        <div class="content">
            <h1 class="main-title">Accueil</h1>

            <?php
                echo $message;
            ?>

            <div class="text">
                <div class="text-text">
                    <h3>Qui sommes-nous ?</h3>
                    
                    <p>Créée en 1960, CarSociety est une équipe de professionnels de l'automobile au service de particuliers et de professionnels aux profils variés. CarSociety France est la filiale française de CarSociety, un des leaders mondiaux de l’industrie automobile et le 1er constructeur européen.</p>
                    <p>Découvrez la vision de CarSociety : « Façonner la mobilité – pour les générations à venir » ! CarSociety apporte des réponses aux défis d’aujourd’hui et de demain :</p>      
                    <p> – Notre objectif est de rendre la mobilité durable pour nous et pour les générations futures</p>
                    <p> – Notre promesse : Grâce à la conduite électrique et à la conduite autonome, nous fabriquons des véhicules propres, silencieux, intelligents et sécuritaires</p>
                    <p> – Dans le même temps, nos véhicules deviennent encore plus émotionnels et offrent une expérience de conduite unique</p>
                    <p> Cette vision fait partie de la solution en matière de protection du climat et de l’environnement.</p>
                    <p> De cette façon, la voiture peut continuer à être une pierre angulaire de la mobilité contemporaine, individuelle et abordable à l’avenir.</p>
                </div>

                <img src="img/team.jpg" class="img-text-1">
            </div>

            <div class="text">
                <img src="img/car-design.jpg" class="img-text-2">

                <div class="text-text">
                    <h3>Le meilleur de l'automobile</h3>
                    <p>CarSociety, pionnière de la transformation de l’industrie automobile, propose des voitures de qualité au design novateur et priorise les questions environnementales en capitalisant sur la création de nouveaux services et le développement de modèles hybrides et électriques. Notre ambition est de devenir le 1er fournisseur de mobilité durable.</p>
                </div>
            </div>

            <div class="text">
                <div class="text-text">
                    <h3>Nos valeurs</h3>
                    <p>Depuis 1960, CarSociety imagine la mobilité de demain. Respect, convivialité, engagement, créativité, simplicité : découvrez les valeurs qui sont les moteurs de nos succès passés, présents et futurs.</p>
                </div>

                <img src="img/inclusion.png" class="img-text-3">
            </div>

            <div class="text">
                <img src="img/integrite.jpg" class="img-text-4">

                <div class="text-text">
                    <h3>Nos engagements</h3>
                    <p>CarSociety est fermement convaincue qu’un succès économique durable ne peut être obtenu qu’en respectant les réglementations et les normes.</p>
                    <p>Nous défendons une conduite honnête et digne de confiance dans le cadre de nos activités quotidiennes, en  conformité avec les règles et réglementations en vigueur.</p>
                    <p>Chez CarSociety, l’intégrité est une pierre angulaire de nos métiers, une partie de notre ADN, qui contribue à garantir la confiance de nos salariés, nos clients, nos partenaires et nos fournisseurs dans notre entreprise et ainsi  notre avenir.</p> 
                    <p>La corruption n’a aucune place chez CarSociety. Nous avons une politique claire :  tolérance zéro tant à l’égard de la corruption active que la corruption passive.</p>
                </div>
            </div>  
        </div>

        <br><br>

        <footer class="footer">
            <div class="legal-informations">
                <h2>CarSociety</h2>
                <img src="img/CarSocietyLogo.png">
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


        <script src="js/goUpButton.js"></script>
        <script src="js/closeMessage.js"></script>
        <script src="js/zoomImage.js"></script>
    </body>
</html>
