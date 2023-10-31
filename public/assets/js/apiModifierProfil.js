
// recuperation de l'input adresse par son id
const adresseInput = document.getElementById('user_adresse');

// recuperation du ul liste_adresse par son id
const adresse_liste = document.getElementById('liste_adresse');


// Fonction pour effectuer la recherche AJAX
function rechercheAdresse() {

    const valeur = adresseInput.value;

    // Vérifiez si la requête est vide
    if (!valeur) {

        // si il n' y a pas de valeur alors la balise 'ul' sera vide, selection de la balise par son id avec la const  adresse_liste
        adresse_liste.innerHTML = '';
        return;
    }

    // Effectuer une requete avec l'API 
    fetch(`https://api-adresse.data.gouv.fr/search/?q=${valeur}&type=housenumber&autocomplete=1`)
        // renvoi une reponse au format JSON
        .then(response => response.json())
        // data contient la reponse au format JSON
        .then(data => {

            console.log('les données sont :', data)
            // Effacez les anciennes suggestions
            adresse_liste.innerHTML = '';

            // Parcours de toute les propriétés dans  la propirété 'features' qui est dans l'API par la map
            data.features.map(feature => {

                console.log('les data features sont :', feature)

                // pour chaque donnée parcourru on créer une liste
                const suggestion = document.createElement('li');
                // en texte on affichera l'adresse 
                suggestion.textContent = feature.properties.label;
                // on inclu la liste dans l'ul
                adresse_liste.appendChild(suggestion);

                // s'il y a un click sur la suggestion alors l'input de l'adresse prendra l'adresse de l'API 
                suggestion.addEventListener('click', () => {

                    adresseInput.value = feature.properties.label;
                    // Effacez les anciennes suggestions
                    adresse_liste.innerHTML = '';
                });
            });
        })
        // si erreur de requete alors affichage dans la console
        .catch(error => {
            console.error('Erreur lors de la récupération des suggestions :', error);
        });
}

// si il y a un evenement dans input de l'adresse alors on enclenchera la fonction rechercheAdresse
adresseInput.addEventListener('input', rechercheAdresse);