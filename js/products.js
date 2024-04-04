// Différents messages pour l'utilisateur en fonction des évènements

let failureMessage2 = `<div class='info-message'>
                            <div class='wrapper-failure'>
                                <div class='card'>
                                    <div class='icon'><i class='fa fa-times-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Échec</h3>
                                        <p>Vous devez ajouter au moins une unité à votre panier !</p>
                                    </div>
                                    
                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>`;

let failureMessage3 = `<div class='info-message'>
                            <div class='wrapper-failure'>
                                <div class='card'>
                                    <div class='icon'><i class='fa fa-times-circle'></i></div>
                                    <div class='subject'>
                                        <h3>Échec</h3>
                                        <p>Une erreur est survenue lors de l'ajout au panier.</p>
                                    </div>

                                    <div class='icon-times'><i class='fas fa-times'></i></div>
                                </div>
                            </div>
                            <br>
                        </div>`;


/*
Cette fonction permet de cacher ou de faire apparaître la colonne "stock" des produits du tableau
(Elle change aussi le texte du bouton associé à la fonction)
Elle ne renvoie rien
*/
function affichage_stock() {
    // Variable contenant toutes les cases à cacher (classe 'invisible')
    const invisible = document.querySelectorAll(".invisible");
	
    // Afficher le stock
    if (document.getElementById("stock-button").innerHTML === "Afficher stock") {
        // Texte du bouton
        document.getElementById("stock-button").innerHTML = "Cacher stock";
		// Chaque élément apparaît en enlevant le display : none
        invisible.forEach(function(element) {
            // Les cellules de la colonne du stock s'affichent comme les autres
            element.style.display = 'table-cell';
        });
		
    } 
    // Cacher le stock
    else {
        // Texte du bouton
        document.getElementById("stock-button").innerHTML = "Afficher stock";
        // Chaque élément disparaît en appliquant display : none
        invisible.forEach(function(element){
            element.style.display = 'none';
        });
    }
}


/*
Cette fonction ajoute une unité au compteur du produit dont la référence est passée en paramètre
Elle ne renvoie rien
*/
function ajout_compteur(reference) {
    // Pour une raison qui nous échappe, la référence (string) passée en paramètre se transforme en un objet <p> dans la fonction
    // Les manipulations se font donc en prenant cela en compte
    
    // La string que nous avons voulu passer en paramètre est l'ID de l'objet détecté par le javascript 
    // Cet objet est le <p> qui correspond à la quantité à ajouter au panier
    let ref = reference.id;
    // Stock courant de l'élément visé
    let stock = document.getElementById("stock-"+ref).innerHTML;

    // Si la quantité à ajouter au panier est égale au stock, impossible de l'augmenter
    if (reference.innerHTML == stock){
        return null;
	
    } 
    // Sinon on peut ajouter un 
    else {
        reference.innerHTML = parseInt(reference.innerHTML) + 1;
    }
}


/*
Cette fonction retire une unité au compteur du produit dont la référence est passée en paramètre
Elle ne renvoie rien
*/
function retrait_compteur(reference) {
    // Même principe que pour ajout_compteur(), cette fois on veille à ce que le compteur ne descende pas en dessous de -1
    if (reference.innerHTML == 0) {
        return null;
    
	} else {
        reference.innerHTML = parseInt(reference.innerHTML) - 1;
    }
}


/*
Cette fonction gère l'ajout au panier d'un produit
Elle prend en paramètre la référence (string) du produit à ajouter ainsi que connected (1 si l'utilisateur est connecté, 0 sinon) 
Elle ne renvoie rien
*/
function ajout_panier(reference, connected) {
    // Même manipulation que dans ajout_compteur()
    let ref = reference.id;
    // Procédure AJAX pour mettre à jour le stock (et remettre le compteur à zéro par sécurité)
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        // Quand l'objet XMLHttpRequest passe à l'état prêt
        if (this.readyState == 4 && this.status == 200) {
            // Erreur : l'utilisateur n'est pas connecté
            if (this.responseText == -1) {
                window.location.href = "../php/set-need-connect.php?cat=" + encodeURIComponent(window.location.pathname + window.location.search);
            
            }
            // Erreur : l'utilisateur essaye d'ajouter 0 produits au panier
            else if (this.responseText == -2) {
                document.getElementById("annonceur").innerHTML = failureMessage2;
            
            }
            // Erreur : erreurs non identifiée
            else if (this.responseText == -3) {
                document.getElementById("annonceur").innerHTML = failureMessage3;
            
            }
            // Succès
            else {
                // Le stock affiché change en fonction du renvoi du script php appelé
                document.getElementById("stock-"+ref).innerHTML = this.responseText;
                // Notification de succès
                document.getElementById("annonceur").innerHTML = `<div class='info-message'>
                                                                    <div class='wrapper-success'>
                                                                        <div class='card'>
                                                                            <div class='icon'><i class='fas fa-check-circle'></i></div>
                                                                            <div class='subject'>
                                                                                <h3>Succès</h3>
                                                                                <p>L'élément <strong>${ref} (x${reference.innerHTML})</strong> a été ajouté au panier !</p>
                                                                            </div>
                                                                            <div class='icon-times'><i class='fas fa-times'></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                </div>`;

                // On additionne la quantité de produits ajoutée au panier à la quantité totale pour obtenir la quantité finale de produits dans le panier
                let totalBasket = parseInt(document.getElementById("total-basket").innerText);
                let quantity = parseInt(reference.innerHTML);

                document.getElementById("total-basket").innerText = totalBasket + quantity;

                // Compteur remis à zéro
                reference.innerHTML = 0;
            }
       }
    };

    // Ouverture d'un script php qui gère la mise à jour de la base de données
    // Paramètres passés en GET : ref (string, référence produit), qte (int, quantité produit), connected (1 ou 0)
    xhttp.open("GET", "../php/add-to-basket.php?ref=" + ref + "&qte=" + reference.innerHTML + "&connected=" + connected, true);
    // Envoi de la requête
    xhttp.send();
}


function retrait_panier(reference) {
    // Même manipulation que dans ajout_compteur()
    let ref = reference.id;

    qte = document.getElementById('qte-'+ref).innerHTML.substring(1);
 
    // Procédure AJAX pour mettre à jour le stock
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        // Quand l'objet XMLHttpRequest passe à l'état prêt
        if (this.readyState == 4 && this.status == 200) {
            // Erreur : erreurs non identifiée
            if (this.responseText == -3) {
                document.getElementById("annonceur").innerHTML = failureMessage3;
            
            }
            // Succès
            else {
                // Le stock affiché change en fonction du renvoi du script php appelé
                document.getElementById(ref).style.display = 'none';
                document.getElementById('prix-total').innerHTML = 'Prix de la commande : ' + this.responseText + ' €';

                // On soustrait la quantité de produits retirée du panier à la quantité totale pour obtenir la quantité finale de produits dans le panier
                let totalBasket = parseInt(document.getElementById("total-basket").innerText);

                document.getElementById("total-basket").innerText = totalBasket - qte;
            }
       }
    };

    // Ouverture d'un script php qui gère la mise à jour de la base de données
    // Paramètres passés en GET : ref (string, référence produit), qte (int, quantité produit), connected (1 ou 0)
    xhttp.open("GET", "../php/remove-from-basket.php?ref=" + ref + "&qte=" + qte, true);
    // Envoi de la requête
    xhttp.send();
}
