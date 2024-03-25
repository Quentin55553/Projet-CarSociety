// Sélectionne tous les éléments de la classe "icon-times"
var closeIcons = document.querySelectorAll('.icon-times');

// Parcoure tous les éléments de la classe "icon-times" afin d'ajouter un gestionnaire d'événements pour le clic
closeIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        // Trouve l'élément parent ayant la classe "info-message" et le masque
        var infoMessage = this.closest('.info-message');

        if (infoMessage) {
            infoMessage.style.display = 'none';
        }
    });
});
