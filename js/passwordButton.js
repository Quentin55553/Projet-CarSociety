// Fonction permettant d'ajuster la valeur de la marge supérieure du bouton pour afficher le mot de passe et le nouveau mot de passe
function moveToggleIcon() {
    // Sélection de l'élément du message d'erreur pour le mot de passe et le nouveau mot de passe
    var passwordErrorMessage = document.getElementById('password-error');
    var newPasswordErrorMessage = document.getElementById('new-password-error');

    // On vérifie si le contenu de la balise pour le message d'erreur relatif au mot de passe est vide
    if (passwordErrorMessage.innerHTML.trim() !== '') {

        // Calcul de la hauteur totale du message d'erreur pour le mot de passe
        var passwordErrorHeight = passwordErrorMessage.offsetHeight - 8;

        var passwordInput = document.getElementById('password');
        var passwordToggleIcon = passwordInput.parentElement.querySelector('.password-toggle-icon');

        // Décalage de l'icône en fonction de la hauteur du message d'erreur pour le mot de passe
        passwordToggleIcon.style.top = 'calc(57% + ' + passwordErrorHeight + 'px)';
    }


    // On vérifie si le contenu de la balise pour le message d'erreur relatif au nouveau mot de passe est vide (si il existe)
    if (newPasswordErrorMessage && (newPasswordErrorMessage.innerHTML.trim() !== '')) {

        // Calcul de la hauteur totale du message d'erreur pour le nouveau mot de passe
        var newPasswordErrorHeight = newPasswordErrorMessage.offsetHeight - 8;

        var newPasswordInput = document.getElementById('new-password');
        var newPasswordToggleIcon = newPasswordInput.parentElement.querySelector('.password-toggle-icon');

        // Décalage de l'icône en fonction de la hauteur du message d'erreur pour le nouveau mot de passe
        newPasswordToggleIcon.style.top = 'calc(57% + ' + newPasswordErrorHeight + 'px)';
    }
}


// Sélection de tous les éléments dont l'ID est ".password-toggle-icon" (et qui comprennent le pictogramme de l'oeil)
document.querySelectorAll('.password-toggle-icon').forEach(function(icon) {
    // Ajout d'un gestionnaire d'événements pour chaque pictogramme d'oeil
    icon.addEventListener('click', function() {
        // Stockage de l'input qui précède le pictogramme d'oeil dans une variable
        var passwordInput = this.previousElementSibling;
        
        // On vérifie si le type est déjà défini sur "password" pour savoir ce qu'il faut faire (afficher ou cacher)
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';

        } else {
            passwordInput.type = 'password';
        }
    });
});


// Création d'un observer pour surveiller les modifications de l'élément contenant le message d'erreur
var observer = new MutationObserver(moveToggleIcon);

// Configuration de l'observer pour surveiller les modifications du contenu de l'élément contenant le message d'erreur
var config = { childList: true, subtree: true };

// Démarrage de l'observation sur les éléments contenant les messages d'erreur pour le mot de passe et le nouveau mot de passe (si il existe)
observer.observe(document.getElementById('password-error'), config);

if (document.getElementById('new-password-error')) {
    observer.observe(document.getElementById('new-password-error'), config);
}

// On appelle la fonction une fois pour prendre en compte le contenu existant au chargement de la page
moveToggleIcon();
