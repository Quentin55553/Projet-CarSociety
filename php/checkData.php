<?php
    // Fonction permettant d'afficher l'erreur spécifique à une entrée si elle existe
    function displayErrors($fieldName, $errors) {
        if (isset($errors[$fieldName])) {
            echo "<i class='fas fa-exclamation-circle' style='color: #D3212CFF;'></i> $errors[$fieldName]";
        }
    }


    // Tableau pour stocker les messages d'erreur
    $errors = [];
    $verificationsPassed = false;


    // Vérification de la soumission du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contactDate = isset($_POST["contact_date"]) ? $_POST["contact_date"] : null;
        $lastName = isset($_POST["lastname"]) ? $_POST["lastname"] : null;
        $firstName = isset($_POST["firstname"]) ? $_POST["firstname"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $object = isset($_POST['object']) ? $_POST['object'] : null;
        $content = isset($_POST['content']) ? $_POST['content'] : null;
        $tel = isset($_POST["tel"]) ? $_POST["tel"] : null;
        
        
        // Vérification de la date de contact
        if (isset($contactDate) && strtotime($contactDate) < strtotime(date('Y-m-d'))) {
            $errors["contact_date"] = "La date de contact doit être définie au minimum à partir de la date actuelle";
        }

        // Vérification du nom
        if (isset($lastName) && !preg_match("/^[a-zA-ZÀ-ÿ]{3,20}(-[a-zA-ZÀ-ÿ]{3,20})*$/", $lastName)) {
            $errors["lastname"] = "Le nom doit contenir des lettres (obligatoires) et peut contenir des tirets (entre des lettres) et doit avoir entre 3 et 20 caractères";
        }

        // Vérification du prénom
        if (isset($firstName) && !preg_match("/^[a-zA-ZÀ-ÿ]{3,20}(-[a-zA-ZÀ-ÿ]{3,20})*$/", $firstName)) {
            $errors["firstname"] = "Le prénom doit contenir des lettres (obligatoires) et peut contenir des tirets (entre des lettres) et doit avoir entre 3 et 20 caractères";
        }

        // Vérification de l'email
        if (isset($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "L'entrée doit avoir le format d'un email";
        }

        // Vérification du genre
        if (isset($gender) && !in_array($gender, array("Homme", "Femme"))) {
            $errors["gender"] = "Le genre doit être soit 'Homme' ou 'Femme'";
        }

        // Vérification de la date de naissance
        if (isset($birthdate) && strtotime($birthdate) > strtotime(date('Y-m-d'))) {
            $errors["birthdate"] = "La date de naissance doit être au maximum égale à la date actuelle";
        }

        // Vérification de la fonction
        if (isset($job)) {
            switch ($job) {
                case "Ingénieur en informatique":
                case "Développeur de logiciels":
                case "Analyste financier":
                case "Avocat":
                case "Comptable":
                case "Enseignant":
                case "Médecin":
                case "Infirmier/infirmière":
                case "Architecte":
                case "Designer graphique":
                case "Marketing Manager":
                case "Chef de projet":
                case "Analyste de données":
                case "Spécialiste des ressources humaines":
                case "Consultant en gestion":
                case "Analyste en cybersécurité":
                case "Écrivain/rédacteur":
                case "Analyste de marché":
                case "Technicien en maintenance":
                case "Agent immobilier":
                    break;

                default:
                    $errors["job"] = "Veuillez sélectionner une fonction dans la liste déroulante";
                    break;
            }
        }

        // Vérification de l'objet
        if (isset($object) && (strlen($object) < 5 || strlen($object) > 35)) {
            $errors["object"] = "L'objet doit avoir entre 5 et 35 caractères";
        }

        // Vérification du contenu
        if (isset($content) && (strlen($content) < 10 || strlen($content) > 500)) {
            $errors["content"] = "Le contenu doit avoir entre 10 et 500 caractères";
        }

        // Vérification du numéro de téléphone
        if (isset($tel) && !preg_match("/^0[1-9](\d{2}){4}$/", $tel)) {
            $errors["tel"] = "Le numéro de téléphone doit être au format français";
        }

        // Vérification du mot de passe
        if (isset($password) && !preg_match("/^.*(?=.*[A-Za-z]).*$/", $password)) {
            $errors["password"] = "L'entrée doit être un mot de passe";
        }

        // Vérification du nouveau mot de passe (pour la page de modification des informations du profil)
        if (isset($newPassword) && !preg_match("/^.*(?=.*[A-Za-z]).*$/", $newPassword)) {
            $errors["new-password"] = "L'entrée doit être un mot de passe";
        }


        // Si aucune erreur n'a été trouvée
        if (empty($errors)) {
            $verificationsPassed = true;
        }
    }
?>
