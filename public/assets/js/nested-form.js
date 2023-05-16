/*document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('mediaTricksContainer');
    var addMediaButton = document.getElementById('add-media-button');
    var index = addMediaButton.dataset.index;

    addMediaButton.addEventListener('click', function() {
        var item = document.createElement('div');
        item.innerHTML = `
            <div class="tricks-create-${index}">
                <label for="tricks_mediaTricks_${index}_mediaFile">Fichier</label>
                <input type="file" class="tricks-media-${index}" id="tricks_mediaTricks_${index}_mediaFile" name="tricks[mediaTricks][${index}][mediaFile]">
                <button type="button" class="remove-media-button">Supprimer</button>
            </div>
        `;
        container.appendChild(item);
        var input = item.querySelector(`.tricks-media-${index}`);
        input.addEventListener('change', (e) => {
            let fileName = input.files[0]
            const test = e.currentTarget

            console.log(fileName);

            /*fetch('/tricks/add/picture', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(fileName) 
            })
            .then(response => response.json())
            .then(data => {
                // Traitez la réponse de la requête
                console.log(data);
            }
        })

        index++;




        // Ajouter un écouteur d'événement pour le bouton de suppression du nouvel élément
        var removeButtons = container.getElementsByClassName('remove-media-button');
        var lastRemoveButton = removeButtons[removeButtons.length - 1];
        lastRemoveButton.addEventListener('click', function() {
            item.remove();
        });
    });
});)*/


    // Sélectionnez les éléments HTML pertinents
    const container = document.getElementById('media-container');
    const addButton = document.querySelector('.add-media');

    // Compteur pour générer des index uniques
    let index = container.querySelectorAll('.media').length;

    // Ajoutez un gestionnaire d'événements au bouton "Ajouter un média"
    addButton.addEventListener('click', () => {
        const prototype = container.getAttribute('data-prototype');
        const newForm = prototype.replace(/__media_Tricks_index__/g, index);

        // Créez un nouvel élément de collection en ajoutant le formulaire généré au DOM
        const newElement = document.createElement('div');
        newElement.classList.add('media');
        newElement.innerHTML = newForm;

        const btnDelete = document.createElement('button');
        btnDelete.classList.add('delete-media');
        btnDelete.textContent = 'Suppirmer cette photo' 

        newElement.appendChild(btnDelete)
        container.appendChild(newElement);

        // Incrémentez le compteur pour le prochain élément
        index++;
    });

    // Ajoutez un gestionnaire d'événements pour supprimer les éléments de collection
    container.addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-media')) {
            event.target.closest('.media').remove();
        }
    });




