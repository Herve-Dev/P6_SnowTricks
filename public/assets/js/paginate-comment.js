let containerComment = document.querySelector('.bloc-comment')
let containerPagination = document.getElementById('containerPagination')

//On récupere l'url actuelle
let currentURL = window.location.href

//On enleve le slash 
let segments = currentURL.split("/");

//On récupere le dernier parametre (en logique id du tricks ou le slug)
let slugTricks = segments[segments.length - 1];


//On prépare une variable pour lui passer id de l'user récupéré
let idUserConnected = null;

//On prépare les données qui seront envoyer à la route pour PHP 
let data = {
  slug: slugTricks ,
}

//Fonction option pour fetch
function getRequestOptions(data) {
  return {
    method: 'POST',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify(data)
  };
}

//On apelle la fonction on lui passe l'objet en parametre
const getDataComment = getRequestOptions(data)

fetch('/comment/api/paginate', getDataComment)
.then(response => {
  if (!response.ok) {
    throw new Error('Erreur de requête : ' + response.status);
  }
  return response.json();
})
.then(data => {

  const userConnected = data.userConnected.isConnected
  const idUserConnected = data.userConnected.idUserConnected
  
  
  const comments = data.data
  
  const itemsPerPage = 10; // Nombre d'éléments à afficher par page

// Fonction pour afficher les commentaires d'une page spécifique
function displayComments(pageNumber) {
  containerComment.innerHTML = '';
  const startIndex = (pageNumber - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const commentsToShow = comments.slice(startIndex, endIndex);
  
  // Afficher les commentaires de la page actuelle
  commentsToShow.forEach(comment => {

      //j'apelle ma fonction pour formater ma date
      let date = formatDate(comment.createdAt.date)

      //On genere html qui sera afficher 
      let commentHTML = generateCommentHTML(comment.user, date, comment.comment, userConnected, idUserConnected, comment.commentIdUser, comment.idComment);
      let commentDiv = document.createElement('div');
      commentDiv.className = "bloc-card-comment-"+ comment.idComment
      commentDiv.classList.add('card-com')
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
    
    // Ajouter le lien à la page 
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

//Fonction pour formater les dates 
function formatDate(dateString) {
  const dateObject = new Date(dateString);
  
  const day = dateObject.getDate();
  const month = dateObject.getMonth() + 1;
  const year = dateObject.getFullYear();
  const hours = dateObject.getHours();
  const minutes = dateObject.getMinutes();
  
  const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}`;
  
  return formattedDate;
}


function generateCommentHTML(username, date, comment, isConnected, idUserConnected, commentIdUser, idComment ) {
  let htmlGenerateWithData =
    `<div class="card-comment">
      <div class="card-comment-header">
          <h3>Posté par : <b>${username}</b> </h3>
          <p> Posté le : <em>${date}</em></p>
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

        <a href="#" uk-icon="icon: trash; ratio: 2" style="background-color : #f0506e; color: black" class="delete-comment" data-comment-id="${idComment}" uk-toggle='target: #my-id-delete-comment${idComment}'></a>
        <div id="my-id-delete-comment${idComment}" uk-modal>
          <div class="uk-modal-dialog uk-modal-body">
              <p>Voulez-vous vraiment supprimer le commentaire : <strong>${comment}</strong> </p>
              <a class="uk-button uk-button-default uk-modal-close" href="#">Annuler</a>
              <a class="uk-button uk-button-danger  uk-modal-close btn-delete-comment-${idComment}" onClick="deleteComment(${idComment},${idUserConnected})" href="#" data-id-delete-comment="${idComment}" data-user="${commentIdUser}" >Supprimer</a>
          </div>
        </div>


        <a href="#" uk-icon="icon: pencil; ratio: 2" style="background-color : #1e87f0; color: black"  onClick="updateCommentWithoutRefresh(${idComment})" class="update-comment" data-comment-id="${idComment}" uk-toggle='target: #my-id-update-comment${idComment}'"></a>
        <div id="my-id-update-comment${idComment}" uk-modal>
          <div class="uk-modal-dialog uk-modal-body">
              <p> Modifier mon commentaire </p>
              
              <form method="post" class="uk-form">
                <textarea class="textarea-${idComment}">${comment}</textarea>
              </form>

              <a class="uk-button uk-button-default uk-modal-close" href="#" >Annuler</a>
              <a class="uk-button uk-button-primary uk-modal-close btn-update-comment-${idComment}" href="#" data-id-update-comment="${idComment}"">valider</a>
          </div>

      </div>
      `
    }

  return htmlGenerateWithData  
}


/**
 * Fonctionn injecter dans 
 * generate html "balise <a class="update-comment"></a>" 
 * je passe directement idComment dans ma fonction généré par js 
 */

function updateCommentWithoutRefresh(idComment) {
  // On récupere le textarea conrespondant au click
  let textarea = document.querySelector(`.textarea-${idComment}`);

  //On récupere le commentaire correspondant
  let comment = document.querySelector(`.paragraph-comment-${idComment}`);
  
  //On ajoute un adeventLister au textarea pour mettre a jour en temps reel le paragraphe
  textarea.addEventListener('input', () => {
    let newValue = escapeHTML(textarea.value) // fonction securité pour l'input

    //insertion nouvelle valeur dans le commentaire
    comment.textContent = newValue;
  });

  //On cible le bouton 'valider'
  const btnUpdateComment = document.querySelector(`.btn-update-comment-${idComment}`)
  btnUpdateComment.addEventListener('click', (e) => {
    e.preventDefault();

    let idUser = parseInt(btnUpdateComment.dataset.user) ;
    
    
    //On creer les données qui seront envoyée a la route php pour le controller
    let dataUpdataComment = {
      idComment: idComment,
      valueUpdateComment: comment.textContent,
      idUser: idUser
    }
    
    let dataToSendFetch = getRequestOptions(dataUpdataComment)

    fetch(`/comment/api/paginate/updateComment/${idComment}`, dataToSendFetch)
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Erreur lors de la requête');
      }
    })
    .then(data => {
      //On stock les datas récupéré dans des variables
      let status = data.data.status;
      let message = data.data.message;

      messageAlert(status, message)
    })
    .catch(error => {
      // Gérez les erreurs ici
      messageAlert(error.status, error.message)
    });
    
  })
  
}


//function pour afficher message req AJAX
function messageAlert(status, message){
if (status === 'error') {
  status = 'danger'
}

  UIkit.notification({
      message: message,
      status: status,
      timeout: 5000
    });
}


// Fonction pour échapper les caractères spéciaux HTML (sécurité injection)
function escapeHTML(value) {
  let newParagrapheComment = document.createElement('p');
  newParagrapheComment.textContent = value;
  return newParagrapheComment.innerHTML;
}


// Fonction pour supprimer un commentaire
function deleteComment(commentId, idUserConnected) {

  // Envoyer une requête de suppression au serveur
  fetch(`/comment/api/paginate/deleteComment/${commentId}/${idUserConnected}`, {
    method: 'DELETE'
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Erreur lors de la requête');
      }
    })
    .then(data => {
      // Faites quelque chose avec les données renvoyées
      let status = data.data.status;
      let message = data.data.message;

      // Supprimer le commentaire de l'affichage
      const commentDiv = document.querySelector(`.bloc-card-comment-${commentId}`);
      if (commentDiv) {
        commentDiv.remove();
      }

      messageAlert(status, message);
    })
    .catch(error => {
      messageAlert('error', error.message);
    });
}

// Ajouter un gestionnaire d'événements pour les boutons de suppression de commentaire
const deleteButtons = document.querySelectorAll('.delete-comment');
deleteButtons.forEach(button => {
  button.addEventListener('click', (e) => {
    e.preventDefault();
    const commentId = button.getAttribute('data-comment-id');
    deleteComment(commentId);
  });
});










 