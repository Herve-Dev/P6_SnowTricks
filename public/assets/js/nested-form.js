document.addEventListener('DOMContentLoaded', function() {
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
        input.addEventListener('change', () => {
            let fileName = input.files[0].name
            console.log(fileName);


            fetch('/add/picture', {
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
            })
        })

        index++;




        // Ajouter un écouteur d'événement pour le bouton de suppression du nouvel élément
        var removeButtons = container.getElementsByClassName('remove-media-button');
        var lastRemoveButton = removeButtons[removeButtons.length - 1];
        lastRemoveButton.addEventListener('click', function() {
            item.remove();
        });
    });
});


