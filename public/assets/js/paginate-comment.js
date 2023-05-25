let containerComment = document.querySelector('.bloc-comment')
let containerPagination = document.getElementById('containerPagination')

let currentURL = window.location.href
let segments = currentURL.split("/");
var idTricks = segments[segments.length - 1];

let data = {
  idTricks: parseInt(idTricks) ,
}

function getRequestOptions(data) {
  return {
    method: 'POST',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify(data)
  };
}

const getDataComment = getRequestOptions(data)

fetch('/comment/api/paginate', getDataComment)
.then(response => {
  if (!response.ok) {
    throw new Error('Erreur de requête : ' + response.status);
  }
  return response.json();
})
.then(data => {
  console.log(data);
  console.log(data.userConnected)

  const userConnected = data.userConnected.isConnected
  const idUserConnected = data.userConnected.idUserConnected
  
  
  const comments = data.data
  
  const itemsPerPage = 2; // Nombre d'éléments à afficher par page

// Fonction pour afficher les commentaires d'une page spécifique
function displayComments(pageNumber) {
  containerComment.innerHTML = '';
  const startIndex = (pageNumber - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const commentsToShow = comments.slice(startIndex, endIndex);
  
  // Afficher les commentaires de la page actuelle
  commentsToShow.forEach(comment => {
    // Afficher le commentaire sur la page (exemple: console.log(comment);)
      let commentHTML = generateCommentHTML(comment.user, comment.createdAt, comment.comment, userConnected, idUserConnected, comment.commentIdUser, comment.idComment);
      let commentDiv = document.createElement('div');
      commentDiv.innerHTML = commentHTML;
      containerComment.appendChild(commentDiv);
    
  });
}

// Fonction pour générer les liens de pagination
function generatePaginationLinks() {
  const totalPages = Math.ceil(comments.length / itemsPerPage);
  
  // Générer les liens de pagination
  for (let i = 1; i <= totalPages; i++) {
    // Créer un élément de lien
    const link = document.createElement('a');
    link.textContent = i;
    
    // Gérer le clic sur le lien
    link.addEventListener('click', () => {
      displayComments(i); // Afficher les commentaires de la page correspondante
    });
    
    // Ajouter le lien à la page (exemple: document.body.appendChild(link);)
    containerPagination.appendChild(link)
  }
}

// Appeler la fonction pour générer les liens de pagination
generatePaginationLinks();

// Afficher les commentaires de la première page initialement
displayComments(1);

  
  
})
.catch(error => {
  console.error('Erreur :', error);
});




function generateCommentHTML(username, date, comment, isConnected, idUserConnected, commentIdUser, idComment ) {
  let htmlGenerateWithData =
    `<div class="card-comment">
      <div class="card-comment-header">
          <h3>Auteur : <b>${username}</b> </h3>
          <p> posté le : <em>${date}</em></p>
      </div>
      <hr>
      <div class="card-comment-body">
          <p> <b>commentaire :</b> </p>
          <p class="paragraph-comment-${idComment}">${comment}</p>
      </div>
    </div>`;

    if(isConnected && idUserConnected === commentIdUser) {
      htmlGenerateWithData += `
      <div class="card-comment-actions">
        <a href="" uk-icon="icon: trash" class="delete-comment" data-comment-id="${idComment}"></a>

        <a href="#" uk-icon="icon: pencil" onClick="test(${idComment})" class="update-comment" data-comment-id="${idComment}" uk-toggle='target: #my-id-update-comment${idComment}'"></a>
        <div id="my-id-update-comment${idComment}" uk-modal>
          <div class="uk-modal-dialog uk-modal-body">
              <p> Modifier mon commentaire </p>
              
              <form method="post" class="uk-form">
                <textarea class="textarea-${idComment}">${comment}</textarea>
              </form>

              <a class="uk-button uk-button-default uk-modal-close" href="#" >Annuler</a>
              <a class="uk-button uk-button-primary btn-update-comment-${idComment}" onClick='apiUpdateComment(${idComment},${idUserConnected})' href="#" data-id-update-comment="${idComment}">valider</a>
          </div>
      </div>
      `
    }

  return htmlGenerateWithData  
}


function updateCommentWithoutRefresh(idComment) {
  // On récupere le textarea conrespondant au click
  let textarea = document.querySelector(`.textarea-${idComment}`);

  //On récupere le commentaire correspondant
  let comment = document.querySelector(`.paragraph-comment-${idComment}`);

  //On ajoute un adeventLister au textarea pour mettre a jour en temps reel le paragraphe
  textarea.addEventListener('input', () => {
    let newValue = escapeHTML(textarea.value)
    comment.textContent = newValue;
  });
}


// Fonction pour échapper les caractères spéciaux HTML (sécurité injection)
function escapeHTML(value) {
  let newParagrapheComment = document.createElement('p');
  newParagrapheComment.textContent = value;
  return newParagrapheComment.innerHTML;
}


function apiUpdateComment(idComment, idUser) {
  //On cible le textarea
  const currentTextarea = document.querySelector(`.textarea-${idComment}`)
  
  //On recupere la value
  const commentValue = currentTextarea.value

  //On recupere le paragraphe du commentaire
  const comment = document.querySelector(`.paragraph-comment-${idComment}`)
  

  const btnUpdateComment = document.querySelector(`.btn-update-comment-${idComment}`)
  btnUpdateComment.addEventListener('click', () => {
    
    comment.textContent = commentValue
    
    console.log(commentValue);
  })

}










 