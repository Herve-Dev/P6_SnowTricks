/*let nextLinkComment = document.getElementById('next-link-comment');
let currentNextPage = nextLinkComment.dataset.currentNext;
let idTricks = nextLinkComment.dataset.tricksId;

nextLinkComment.addEventListener('click', (e) => {
    e.preventDefault();

    let data = {
        idTricks: parseInt(idTricks) ,
        page : parseInt(currentNextPage) 
    }

    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    }

    fetch('/comment/api/paginate', requestOptions)
    .then(response => {
        if (!response.ok) {
          throw new Error('Erreur de requête : ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        console.log(data);
        data.data.forEach(element => {
          console.log(element);
          showDataPage(element.user, element.createdAt, element.comment)
        })
        
      })
      .catch(error => {
        console.error('Erreur :', error);
      });
})

function showDataPage(username, datetime, contentComment) {
  let selectAuthors = document.querySelectorAll('.card-comment-header h3 b');
  selectAuthors.forEach(author => {
    console.log( author.textContent = username); 
  });

  let selectCreated = document.querySelectorAll('.card-comment-header p em')
  selectCreated.forEach(date => {
    console.log(date.textContent = datetime);
  })

  let comments = document.querySelectorAll('.paragraph-comment')
  comments.forEach(comment => {
    console.log(comment.textContent = contentComment);
  })
}*/



let containerComment = document.querySelector('.bloc-comment')
let containerPagination = document.getElementById('containerPagination')

let currentURL = window.location.href
let segments = currentURL.split("/");
var idTricks = segments[segments.length - 1];

let data = {
  idTricks: parseInt(idTricks) ,
}

const requestOptions = {
  method: 'POST',
  headers: {
      'Content-type': 'application/json'
  },
  body: JSON.stringify(data)
}

fetch('/comment/api/paginate', requestOptions)
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
      console.log(commentHTML);
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
          <p class="paragraph-comment">${comment}</p>
      </div>
    </div>`;

    if(isConnected && idUserConnected === commentIdUser) {
      htmlGenerateWithData += `
      <div class="card-comment-actions">
        <a href="" uk-icon="icon: trash" class="delete-comment" data-comment-id="${idComment}"></a>
        <a href="#" uk-icon="icon: pencil" class="update-comment" data-comment-id="${idComment}"></a>
      </div>
      `
    }

  return htmlGenerateWithData  
}












/*function paginateData(arrayData) {
  const elementsPerPage = 2; // Nombre d'éléments par page
  let pageIndex = 0; // Index de la page en cours

  arrayData.forEach((element, index) => {
    const currentPageIndex = Math.floor(index / elementsPerPage);
    
    console.log(element)

    if (currentPageIndex === pageIndex) {
      // Faites quelque chose avec l'élément de la page en cours (par exemple, l'afficher)
      
      
      let commentHTML = generateCommentHTML(element.user, element.createdAt, element.comment);
      let commentDiv = document.createElement('div');
      commentDiv.innerHTML = commentHTML;
      containerComment.appendChild(commentDiv);
    }

    if ((index + 1) % elementsPerPage === 0) {
      pageIndex++;
    }
  });
}*/

/*function paginateData(arrayData) {
  const elementsPerPage = 2; // Nombre d'éléments par page
  const totalPages = Math.ceil(arrayData.length / elementsPerPage); // Nombre total de pages

  for (let page = 1; page <= totalPages; page++) {
    let startIndex = (page - 1) * elementsPerPage;
    let endIndex = startIndex + elementsPerPage;
    let currentPageData = arrayData.slice(startIndex, endIndex);

    console.log(currentPageData);

    currentPageData.forEach(element => {
      let commentHTML = generateCommentHTML(element.user, element.createdAt, element.comment);
      //console.log(commentHTML); // Affiche le HTML généré pour l'élément
      // Faites quelque chose avec le HTML généré, par exemple, l'ajouter à votre page
      // let commentDiv = document.createElement('div');
      // commentDiv.innerHTML = commentHTML;
      // containerComment.appendChild(commentDiv);
    });
  }
}*/

/*function paginateData(arrayData) {
  const elementsPerPage = 2; // Nombre d'éléments par page
  const totalPages = Math.ceil(arrayData.length / elementsPerPage); // Nombre total de pages

  for (let page = 1; page <= totalPages; page++) {
    let startIndex = (page - 1) * elementsPerPage;
    let endIndex = startIndex + elementsPerPage;
    let currentPageData = arrayData.slice(startIndex, endIndex);

    console.log("Page", page);
    console.log(currentPageData);

    currentPageData.forEach(element => {
      let commentHTML = generateCommentHTML(element.user, element.createdAt, element.comment);
      console.log(commentHTML); // Affiche le HTML généré pour l'élément
      // Faites quelque chose avec le HTML généré, par exemple, l'ajouter à votre page
       let commentDiv = document.createElement('div');
       commentDiv.innerHTML = commentHTML;
       containerComment.appendChild(commentDiv);
    });

    // Créer un lien pour chaque page
    let pageLink = document.createElement('a');
    pageLink.href = '#'; // Modifier l'URL de la page en conséquence
    pageLink.textContent = page;
    // Ajouter un gestionnaire d'événements pour afficher la page correspondante lorsque le lien est cliqué
    pageLink.addEventListener('click', () => {
      displayPage(page, arrayData);
    });
    // Ajouter le lien à votre conteneur de liens de pagination
     containerComment.appendChild(pageLink);
  }
}

function displayPage(page, arrayData) {
  const elementsPerPage = 2; // Nombre d'éléments par page
  let startIndex = (page - 1) * elementsPerPage;
  let endIndex = startIndex + elementsPerPage;
  let currentPageData = arrayData.slice(startIndex, endIndex);

  // Effacer le contenu actuel de votre conteneur de commentaires
  containerComment.innerHTML = '';

  currentPageData.forEach(element => {
    let commentHTML = generateCommentHTML(element.user, element.createdAt, element.comment);
    // Faites quelque chose avec le HTML généré, par exemple, l'ajouter à votre page
     let commentDiv = document.createElement('div');
     commentDiv.innerHTML = commentHTML;
     containerComment.appendChild(commentDiv);
  });
}


function generateCommentHTML(username, date, comment) {
  let htmlGenerateWithData =
    `<div class="card-comment">
      <div class="card-comment-header">
          <h3>Auteur : <b>${username}</b> </h3>
          <p> posté le : <em>${date}</em></p>
      </div>
      <hr>
      <div class="card-comment-body">
          <p> <b>commentaire :</b> </p>
          <p class="paragraph-comment">${comment}</p>
      </div>
    </div>`

  return htmlGenerateWithData  
}*/


 