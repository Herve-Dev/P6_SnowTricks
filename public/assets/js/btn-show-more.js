let blocItemMain2 = document.querySelector('.bloc-item-main-2');
let tricksContainer = document.querySelector('.container-tricks');
let showMoreButton = document.getElementById('showMoreButton');
let tricks = document.querySelectorAll('.card-tricks');
let visibleTricksCount = 4;

// Afficher les éléments initiaux
for (let i = 0; i < visibleTricksCount; i++) {
  tricks[i].style.display = 'block';
}

showMoreButton.addEventListener('click', function() {
  // Afficher tous les éléments restants
  for (let i = visibleTricksCount; i < tricks.length; i++) {
    tricks[i].style.display = 'block';
  }

  // Masquer le bouton "Afficher plus"
  showMoreButton.style.display = 'none';

  // Réinitialiser la hauteur de bloc-item-main-2
  blocItemMain2.style.height = 'auto';
  
  // Mettre à jour la hauteur du bloc v-slider-bloc bloc-2
  let totalHeight = blocItemMain2.offsetHeight;
  let containerHeight = tricksContainer.offsetHeight;

  
  if (totalHeight > containerHeight) {
    blocItemMain2.style.height = 'auto';
  } else {
    blocItemMain2.style.height =  'auto';
  }
});
