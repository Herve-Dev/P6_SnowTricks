let links = document.querySelectorAll("[data-delete]");

// On boucle sur les liens
for(let link of links) {
    // On met un écouteur d'évenements
    link.addEventListener("click", function(e){
        // On empêchela navidation
        e.preventDefault();

        // On demande confimation
        if (confirm("Voulez-vous supprimer cette image ?")) {
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