// Sélection de l'élément du bouton "Retour en haut" par son ID
var btn = $('#goUpButton');


// Gestionnaire d'événement pour le défilement de la fenêtre
$(window).scroll(function() {
    // On vérifie si la position de défilement est supérieure à 300 pixels
    if ($(window).scrollTop() > 300) {
        // On ajoute la classe 'show' au bouton si la condition est vraie (ce qui le fait apparaître)
        btn.addClass('show');

    } else {
        // Sinon, on supprime la classe 'show' (ce qui le fait disparaître)
        btn.removeClass('show');
    }
});


// Gestionnaire d'événement pour le clic sur le bouton "Retour en haut"
btn.on('click', function(e) {
    // Empêche le comportement du clic sur le bouton par défaut
    e.preventDefault();

    // Fait défiler la page vers le haut de façon douce (fonction animate)
    $('html, body').animate({scrollTop: 0}, '300');
});
