//Je cible le footer
const targetFooter = document.getElementById('target-footer');

//Je cible le bloc-item-main
const blocItemMain2 = document.querySelector('.bloc-item-main-2');

//Je cible le bouton et lui ajouter un écouteur évenement
const showMoreButton = document.getElementById('showMoreButton')
showMoreButton.addEventListener('click', () => {

  //Au clique je passe le bloc en auto pour afficher tout les tricks
  blocItemMain2.style.height = "auto"
  
  //je rajoute un scroll view smooth pour cibler la fin des éléments
  targetFooter.scrollIntoView({
    behavior: 'smooth',
  });

  //Je retire le bouton showMore 
  showMoreButton.style.display = 'none'

})