// Fonction permettant de signaler une erreur sur une input spécifique d'un formulaire
function setError(input, spanId, message, radio) {
    if (radio) {
        input.forEach(function(input) {
            input.style.outline = '2px solid red';
        });

    } else {
        input.style.backgroundColor = "#D3212CFF";
        input.style.color = "white";
    }

    // Ajout du message d'erreur
    document.getElementById(spanId).classList.add("with-content");
    document.getElementById(spanId).innerHTML = '<i class="fas fa-exclamation-circle" style="color: #D3212CFF;"></i> ' + message;
}


function validateForm() {
    // Variable permettant de stocker la première mauvaise entrée
    var firstWrongInput = null;

    var contactDateInput = document.getElementById("contact_date") ? document.getElementById("contact_date") : null;
    var lastNameInput = document.getElementById("lastname") ? document.getElementById("lastname") : null;
    var firstNameInput = document.getElementById("firstname") ? document.getElementById("firstname") : null;
    var emailInput = document.getElementById("email") ? document.getElementById("email") : null;
    var genderInputs = document.getElementById("gender-error")? document.querySelectorAll('input[name="gender"]') : null;
    var birthdateInput = document.getElementById("birthdate") ? document.getElementById("birthdate") : null;
    var jobInput = document.getElementById("job") ? document.getElementById("job") : null;
    var objectInput = document.getElementById("object") ? document.getElementById("object") : null;
    var contentInput = document.getElementById("content") ? document.getElementById("content") : null;
    var telInput = document.getElementById("tel") ? document.getElementById("tel") : null;
    var passwordInput = document.getElementById("password") ? document.getElementById("password") : null;
    var newPasswordInput = document.getElementById("new-password") ? document.getElementById("new-password") : null;


    // Vérification de la date de contact
    if (contactDateInput != null && !contactDateInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? contactDateInput : firstWrongInput;

        setError(contactDateInput, "contact_date-error", "La date de contact doit être définie au minimum à partir de la date actuelle", 0);
    }

    // Vérification du nom
    if (lastNameInput != null && (!lastNameInput.checkValidity() || !/^[a-zA-ZÀ-ÿ]+(?:-[a-zA-ZÀ-ÿ]+)*$/.test(lastNameInput.value))) {
        firstWrongInput = firstWrongInput === null ? lastNameInput : firstWrongInput;

        setError(lastNameInput, "lastname-error", "Le nom doit contenir des lettres (obligatoires) et peut contenir des tirets (entre des lettres) et doit avoir entre " + lastNameInput.getAttribute("minlength") + " et " + lastNameInput.getAttribute("maxlength") + " caractères", 0);
    }

    // Vérification du prénom
    if (firstNameInput != null && (!firstNameInput.checkValidity() || !/^[a-zA-ZÀ-ÿ]+(?:-[a-zA-ZÀ-ÿ]+)*$/.test(firstNameInput.value))) {
        firstWrongInput = firstWrongInput === null ? firstNameInput : firstWrongInput;

        setError(firstNameInput, "firstname-error", "Le prénom doit contenir des lettres (obligatoires) et peut contenir des tirets (entre des lettres) et doit avoir entre " + firstNameInput.getAttribute("minlength") + " et " + firstNameInput.getAttribute("maxlength") + " caractères", 0);
    }

    // Vérification de l'email
    if (emailInput != null && !emailInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? emailInput : firstWrongInput;

        setError(emailInput, "email-error", "L'entrée doit avoir le format d'un email", 0);
    }

    // Vérification du genre
    if (genderInputs != null) {
        var genderSelected = false;
        var genderValue;
        genderInputs.forEach(function(input) {
            if (input.checked) {
                genderSelected = true;
                genderValue = input.value;
            }
        });
        if (!genderSelected || (genderValue !== "Homme" && genderValue !== "Femme")) {
            firstWrongInput = firstWrongInput === null ? document.getElementById("gender-error") : firstWrongInput;

            setError(genderInputs, "gender-error", "Le genre doit être 'Homme' ou 'Femme'", 1);
        }
    }

    // Vérification de la date de naissance
    if (birthdateInput != null && !birthdateInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? birthdateInput : firstWrongInput;

        setError(birthdateInput, "birthdate-error", "La date de naissance doit être définie au maximum à la date actuelle", 0);
    }

    // Vérification de la fonction
    if (jobInput != null && !jobInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? jobInput : firstWrongInput;

        setError(jobInput, "job-error", "Veuillez sélectionner une fonction dans la liste déroulante", 0);
    }

    // Vérification de l'objet
    if (objectInput != null && !objectInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? objectInput : firstWrongInput;

        setError(objectInput, "object-error", "Le sujet doit avoir entre " + objectInput.getAttribute("minlength") + " et " + objectInput.getAttribute("maxlength") + " caractères", 0);
    }

    // Vérification du contenu
    if (contentInput != null && !contentInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? contentInput : firstWrongInput;

        setError(contentInput, "content-error", "Le contenu doit avoir entre " + contentInput.getAttribute("minlength") + " et " + contentInput.getAttribute("maxlength") + " caractères", 0);
    }

    // Vérification du numéro de téléphone
    if (telInput != null && !telInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? passwordInput : firstWrongInput;

        setError(telInput, "tel-error", "Le numéro de téléphone doit être au format français", 0);
    }

    // Vérification du mot de passe
    if (passwordInput != null && !passwordInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? passwordInput : firstWrongInput;

        setError(passwordInput, "password-error", "L'entrée doit être un mot de passe", 0);
    }

    // Vérification du nouveau mot de passe (pour la page de modification des informations du profil)
    if (newPasswordInput != null && !newPasswordInput.checkValidity()) {
        firstWrongInput = firstWrongInput === null ? newPasswordInput : firstWrongInput;

        setError(newPasswordInput, "new-password-error", "L'entrée doit être un mot de passe", 0);
    }


    // Si au moins une mauvaise entrée a été détectée
    if (firstWrongInput != null) {
        firstWrongInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    
    }


    // Si toutes les validations réussissent, on retourne "true"
    return true;
}


document.querySelector('form').addEventListener("submit", function(event) {
    // Annule le comportement par défaut provoqué par un click sur un bouton submit (envoi direct) pour pouvoir effectuer la validation avec JavaScript en premier
    event.preventDefault();


    // Si les vérifications se sont faites avec succès, on envoie le formulaire
    if (validateForm()) {
        this.submit();
    }
});
