
//Désactiver le bouton si aucun média
const btnAddTricks = document.querySelector('.btn-sub-tricks')
btnAddTricks.disabled = true


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
    btnDelete.classList.add('uk-button');
    btnDelete.textContent = 'Suppirmer cette photo' 

    newElement.appendChild(btnDelete)
    container.appendChild(newElement);

    //Condition pour activer bouton submit
    const inputMedia = document.querySelector('.media > div > input')
    inputMedia.addEventListener('change', () => {
        btnAddTricks.disabled = false
    })

    // Incrémentez le compteur pour le prochain élément
    index++;
});

// Ajoutez un gestionnaire d'événements pour supprimer les éléments de collection
container.addEventListener('click', (event) => {
    if (event.target.classList.contains('delete-media')) {
        event.target.closest('.media').remove();

        //Désactiver bouton submit si media inexistant
        const mediaExist = document.querySelector('.media');
        if (mediaExist === null) {
            btnAddTricks.disabled = true
        }
    }
});


const containerVideo = document.getElementById('video-container');
const addVideoButton = document.querySelector('.add-video');

// Compteur pour générer des index uniques
let indexVideoForm = container.querySelectorAll('.video_form').length;

// Ajoutez un gestionnaire d'événements au bouton "Ajouter un média"
addVideoButton.addEventListener('click', () => {
    const prototype = containerVideo.getAttribute('data-prototype');
    const newFormVideo = prototype.replace(/__video_Tricks_index__/g, indexVideoForm);

    // Créez un nouvel élément de collection en ajoutant le formulaire généré au DOM
    const newElement = document.createElement('div');
    newElement.classList.add('video_form');
    newElement.innerHTML = newFormVideo;

    const btnDelete = document.createElement('button');
    btnDelete.classList.add('delete-url');
    btnDelete.textContent = 'Suppirmer cette url' 

    newElement.appendChild(btnDelete)
    container.appendChild(newElement);

    // Incrémentez le compteur pour le prochain élément
    indexVideoForm++;
});

// Ajoutez un gestionnaire d'événements pour supprimer les éléments de collection
container.addEventListener('click', (event) => {
    if (event.target.classList.contains('delete-url')) {
        event.target.closest('.video_form').remove();
    }
});




