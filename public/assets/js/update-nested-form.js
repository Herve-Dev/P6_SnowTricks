// Sélectionnez les éléments HTML pertinents
const container = document.getElementById('container-media-update');
const addButton = document.querySelector('.add-new-media');

// Compteur pour générer des index uniques
let index = container.querySelectorAll('.media-new-add').length;

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
    btnDelete.classList.add('uk-button-danger');
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








const containerVideo = document.getElementById('container-video-update');
const addVideoButton = document.querySelector('.add-new-video');

// Compteur pour générer des index uniques
let indexVideoForm = container.querySelectorAll('.media-new-video').length;

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
    btnDelete.classList.add('uk-button-danger');
    btnDelete.classList.add('uk-button');
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