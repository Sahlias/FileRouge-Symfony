// selection de l'input date entrée par son id
let dateEntree = document.getElementById("reservation_form_DateEntree");
// selection de l'input date sortie par son id
let dateSortie = document.getElementById("reservation_form_DateSortie");
// selection du paragraphe pour affichage résultat nombre de jours par son id
let paragrapheJours = document.getElementById("jours");
// selection du tarif dans la <li> par son id
let tarif = document.getElementById("tarif");
// selection du montantTotal pour affichage du total dans le <h5> par son id
let montantTotal = document.getElementById("total");

// let totalMontant = document.getElementById('totalMontant');

function calculJours() {

    
    // selectionner les valeurs de date entrée et date sortie
    let dateEntreeValue = dateEntree.value;
    let dateSortieValue = dateSortie.value;

    /*Vérifiez si les deux champs de date ont été remplis, si pas de vérification des deux champs 
     en meme temps alors va afficher 'nan' lors de la selection de la date d'entrée */
    if (dateEntreeValue && dateSortieValue) {

    // Convertir les chaînes de caracteres en objets Date
    var dateEntreeObj = new Date(dateEntreeValue);
    var dateSortieObj = new Date(dateSortieValue);

    // Calculez la différence en millisecondes
    var difference = dateSortieObj - dateEntreeObj;

    // Calculez le nombre de jours en divisant par le nombre de millisecondes par jour
    // on ajoute +1 pour eviter le '0jour' si on a par exemple en date le 25/01/2023 au 25/01/2023
    var differenceJours = difference / (1000 * 3600 * 24);

    // affichage du résultat dans le paragraphe
    paragrapheJours.textContent =
    "Nombre de jour(s) reservé(s) : " + differenceJours + "jour(s)";

    // recupération du contenue de la variable
    // La fonction parseFloat() permet de transformer une chaîne de caractères en un nombre flottant
    var total = parseFloat(tarif.textContent);

    // Calculez le total en multipliant par le nombre de jours
    var totalReservation = total * differenceJours;

    montantTotal.textContent = parseFloat(totalReservation) + "€";

    } else {
    // Si l'une des dates est manquante, réinitialiser le résultat
    paragrapheJours.textContent = "";
    montantTotal.textContent = 0 + "€";
    }

}

// Appelez la fonction calculJours lorsque la valeur du champ de date d'entrée et date de sortie change.
dateEntree.addEventListener("change", calculJours);
dateSortie.addEventListener("change", calculJours);




/* BLOQUER UNE DATE DE SORTIE ANTERIEURE A LA DATE D'ENTREE
__________________________________________________________________________________________________________________________*/

// si la date d'entrée change
dateEntree.addEventListener("change", function () {

   // Obtenir la valeur de la date d'entrée et convetir la valeur en objet date
   var dateEntreeValue = new Date(dateEntree.value);

   // Ajouter un jour à la date d'entrée
   dateEntreeValue.setDate(dateEntreeValue.getDate() + 1);

  // l'attribut min du champ de date de sortie va prendre en valeur la date d'entrée
  dateSortie.min = dateEntreeValue.toISOString().split('T')[0];  // Format YYYY-MM-DD

});
