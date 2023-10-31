
// fonction avec en parametre l'id de la chambre
function afficherDetails(chambreId) {

    // on va selectionner la div description par son id (grace au parametre chambreId que l'on a déclaré)
    var description = document.getElementById('description-' + chambreId);
    // on va selectionner la div options par son id (grace au parametrechambreId que l'on a déclaré)
    var options = document.getElementById('options-' + chambreId);

    // conditions
    // par défaut, La div option et description est en display:none sur le css, cad que cela ne s'affiche pas 
    // si le display est en none alors quand je vais cliquer la div option et description passera en display:block (donc affichage des élements)
    if (description.style.display === 'none') {

        description.style.display = 'block';
        options.style.display = 'block';

    // dans le cas inverse(si ce n'est pas en display: none), lorsque je vais re-cliquer la div option et description va repasser en display:none
    } else {
        
        description.style.display = 'none';
        options.style.display = 'none';
    }
}