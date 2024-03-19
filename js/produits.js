

function affichage_stock(){
    const invisible=document.querySelectorAll(".invisible");
    if(document.getElementById("stock-button").innerHTML==="Afficher stock"){
        document.getElementById("stock-button").innerHTML="Cacher stock";
        invisible.forEach(function(element){
            element.style.display='block';
            element.style.borderCollapse='collapse';
        });
    }
    else{
        document.getElementById("stock-button").innerHTML="Afficher stock";
        invisible.forEach(function(element){
            element.style.display='none';
        });
    }
}

/*
Cette fonction ajoute une unité au compteur produit dont la référence est passée en paramètre

Elle ne renvoie rien
*/
function ajout_compteur(reference){
    console.log(reference);
    reference.innerHTML=parseInt(reference.innerHTML)+1;
}

/*
Cette fonction retire une unité au compteur du produit dont la référence est passée en paramètre

Elle ne renvoie rien
*/
function retrait_compteur(reference){
    if(reference.innerHTML==0){
        return null;
    }
    else{
        reference.innerHTML=parseInt(reference.innerHTML)-1;
    }
}

function ajout_panier(reference){

}