
let successMessage = 
`<div class='info-message'>
    <div class='wrapper-success'>
        <div class='card'>
            <div class='icon'><i class='fas fa-check-circle'></i></div>
            <div class='subject'>
                <h3>Succès</h3>
                <p>L'élément a été ajouté au panier !</p>
            </div>
            <div class='icon-times'><i class='fas fa-times'></i></div>
        </div>
    </div>
    <br>
</div>`;

let failureMessage1=
`<div class='info-message'>
    <div class='wrapper-failure'>
        <div class='card'>
            <div class='icon'><i class='fa fa-times-circle'></i></div>
            <div class='subject'>
                <h3>Échec</h3>
                <p>Vous devez être connecté pour ajouter un élément au panier.</p>
            </div>

            <div class='icon-times'><i class='fas fa-times'></i></div>
        </div>
    </div>
    <br>
</div>`;

let failureMessage2=
`<div class='info-message'>
    <div class='wrapper-failure'>
        <div class='card'>
            <div class='icon'><i class='fa fa-times-circle'></i></div>
            <div class='subject'>
                <h3>Échec</h3>
                <p>Ajoutez au moins une unité !</p>
            </div>
            <div class='icon-times'><i class='fas fa-times'></i></div>
        </div>
    </div>
    <br>
</div>`;

let failureMessage3=
`<div class='info-message'>
    <div class='wrapper-failure'>
        <div class='card'>
            <div class='icon'><i class='fa fa-times-circle'></i></div>
            <div class='subject'>
                <h3>Échec</h3>
                <p>Une erreur est survenue.</p>
            </div>

            <div class='icon-times'><i class='fas fa-times'></i></div>
        </div>
    </div>
    <br>
</div>`;

function affichage_stock() {
    const invisible = document.querySelectorAll(".invisible");
	
    if (document.getElementById("stock-button").innerHTML === "Afficher stock") {
        document.getElementById("stock-button").innerHTML = "Cacher stock";
		
        invisible.forEach(function(element){
            element.style.display = 'block';
            element.style.borderCollapse = 'collapse';
        });
		
    } else {
        document.getElementById("stock-button").innerHTML="Afficher stock";
        invisible.forEach(function(element){
            element.style.display = 'none';
        });
    }
}


/*
Cette fonction ajoute une unité au compteur produit dont la référence est passée en paramètre
Elle ne renvoie rien
*/
function ajout_compteur(reference) {
    let ref = reference.id;
    let stock=document.getElementById("stock-"+ref).innerHTML;
    if (reference.innerHTML==stock){
        return null;
	} 
    else {
        reference.innerHTML = parseInt(reference.innerHTML) + 1;
    }
}

/*
Cette fonction retire une unité au compteur du produit dont la référence est passée en paramètre
Elle ne renvoie rien
*/
function retrait_compteur(reference) {
    if (reference.innerHTML == 0) {
        return null;
    
	} else {
        reference.innerHTML = parseInt(reference.innerHTML) - 1;
    }
}


function ajout_panier(reference,connected) {
    let ref = reference.id;
    // AJAX pour avoir le stock du produit
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText==-1){
                document.getElementById("annonceur").innerHTML=failureMessage1;
            }
            else if(this.responseText==-2){
                document.getElementById("annonceur").innerHTML=failureMessage2;
            }
            else if(this.responseText==-3){
                document.getElementById("annonceur").innerHTML=failureMessage3;
            }
            else{
                document.getElementById("stock-"+ref).innerHTML=this.responseText;
                reference.innerHTML=0;
                document.getElementById("annonceur").innerHTML=successMessage;
            }
       }
    };
    xhttp.open("GET","../php/add-to-basket.php?ref="+ref+"&qte="+reference.innerHTML+"&connected="+connected,true);
    xhttp.send();
}

