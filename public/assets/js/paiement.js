let inputDateExpiration = document.getElementById("paiement_date_expiration");
let inputNumcarte = document.getElementById("paiement_card_number");

// fonction pour ajouter un slash à l'input date d'expiration
function addSlash(event) {

    // recuperation du champs ou il y aura l'évenement, on vise ce champs pour faire passer la fonction
    inputDateExpiration = event.target;
    // Supprime tous les caractères non numériques, on ne pourra mettre que des chiffres dans le champs
    var valueDateExpiration = inputDateExpiration.value.replace(/\D/g, ''); 
    // utilise une autre expression régulière lorsqu'on va ecrire dans notre champs, va ajouter  un slash (/) entre les deux premiers chiffres et les deux chiffres suivants
    var valeurFormatee = valueDateExpiration.replace(/(\d{2})(\d{2})/, '$1/$2'); 

    // input date d'expiration va prendre dans son champs la valeur formatée 
    inputDateExpiration.value = valeurFormatee;
}



// fonction pour ajouter un espace à l'input numéro carte bancaire 
function addSpace(event) {

    // recuperation du champs ou il y aura l'évenement, on vise ce champs pour faire passer la fonction
    inputNumcarte = event.target;
    // Supprime tous les caractères non numériques, on ne pourra mettre que des chiffres dans le champs
    var valueNumcarte = inputNumcarte.value.replace(/\D/g, ''); 
    // utilise une autre expression régulière lorsqu'on va ecrire dans notre champs, va ajouter un espace entre les 4 chiffres
    var valeurFormatee = valueNumcarte.replace(/(\d{4})/g, '$1 ');

    inputNumcarte.value = valeurFormatee.trim(); // Supprime les espaces en trop à la fin
}