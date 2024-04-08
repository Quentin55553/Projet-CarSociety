// Définition de la fonction pour la gestion des clics de fermeture des notifications
function addCloseEventListeners() {
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
}


// Ajout d'un écouteur d'événements "MutationObserver" pour détecter les changements dans le DOM
var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        // Vérifie si des éléments sont ajoutés au DOM
        if (mutation.addedNodes && mutation.addedNodes.length > 0) {
            // Vérifie si les éléments ajoutés contiennent des notifications
            var addedNotifications = document.querySelectorAll('.info-message');

            if (addedNotifications.length > 0) {
                // Si des notifications ont été ajoutées, on lance à nouveau le gestionnaire d'événements pour prendre en compte ces nouvelles notifications
                addCloseEventListeners();
            }
        }
    });
});


// Configuration de l'observateur pour surveiller les ajouts d'enfants au nœud racine ainsi que les attributs des nœuds
var observerConfig = { childList: true, subtree: true };


// Appel initial pour lancer le gestionnaire d'événements aux icônes de fermeture déjà existantes de base
addCloseEventListeners();

// Démarre l'observation du document avec la configuration spécifiée
observer.observe(document.body, observerConfig);
