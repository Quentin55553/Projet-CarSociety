function zoomImage() {
    // On crée le conteneur principal qui va contenir l'image et le bouton pour la fermer
    var imageContainer = document.createElement("div");
    imageContainer.className = "image-container";

    // On crée l'image qui va être ajouté au conteneur
    var image = document.createElement("img");
    // this est l'image avec laquelle on a lancé la fonction
    image.src = this.src;

    // On crée le bouton pour fermer l'image qui va être ajouté au conteneur
    var closeButton = document.createElement("button");
    closeButton.innerHTML = "&times;";
    closeButton.className = "close-btn";

    // On définit la fonction qui est déclenchée lorsqu'on appui sur le bouton pour fermer l'image
    closeButton.onclick = function() {
        // Si l'utilisateur a appuyé sur la croix, on supprime le conteneur du corps de la page
        document.body.removeChild(imageContainer);
    };

    // On ajoute le bouton pour fermer l'image au conteneur principal
    imageContainer.appendChild(closeButton);
    // On ajoute l'image au conteneur principal
    imageContainer.appendChild(image);

    // On ajoute le conteneur principal au corps de la page
    document.body.appendChild(imageContainer);
}


// On sélectionne tous les éléments dans la classe "content"
var contentElements = document.querySelectorAll(".content");
// On parcours chaque élément dans la classe "content" et on met un écouteur d'événements pour chaque image qui s'y trouve pour détecter un click et lancer la fonction zoomImage()
contentElements.forEach(function(contentElement) {
    var imagesInsideContent = contentElement.querySelectorAll("img");

    imagesInsideContent.forEach(function(image) {
        image.addEventListener("click", zoomImage);
    });
});
