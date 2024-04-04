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
