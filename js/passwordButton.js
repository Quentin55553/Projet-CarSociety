// Fonction permettant d'ajuster la valeur de la marge supérieure du bouton pour afficher le mot de passe
function moveToggleIcon() {
    // Sélection de l'élément du message d'erreur
    var errorMessage = document.getElementById('password-error');

    // On vérifie si le contenu de l'élément est vide
    if (errorMessage.innerHTML.trim() !== '') {

        // Calcul de la hauteur totale du message d'erreur
        var errorHeight = errorMessage.offsetHeight - 8;

        var passwordInput = document.getElementById('password');
        var toggleIcon = passwordInput.parentElement.querySelector('.password-toggle-icon');

        // Décalage de l'icône en fonction de la hauteur du message d'erreur
        toggleIcon.style.top = 'calc(57% + ' + errorHeight + 'px)';
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

// Démarrage de l'observation sur l'élément contenant le message d'erreur
observer.observe(document.getElementById('password-error'), config);

// On appelle la fonction une fois pour prendre en compte le contenu existant au chargement de la page
moveToggleIcon();
