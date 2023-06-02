let linksVideo = document.querySelectorAll("[data-delete-video]");

// On boucle sur les liens
for(let link of linksVideo) {
    // On met un écouteur d'évenements
    link.addEventListener("click", function(e){
        // On empêche la navidation
        e.preventDefault();

        // On demande confimation
        if (confirm("Voulez-vous supprimer cette video ?")) {
            // On envoie la reqête ajax
            fetch(this.getAttribute("href"), {
                method: "DELETE",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({"_token": this.dataset.token})
            }).then(response => response.json())
            .then(data => {
                if(data.success){
                    this.parentElement.remove();
                }else{
                    alert(data.error);
                }
            })
        }
    })

}