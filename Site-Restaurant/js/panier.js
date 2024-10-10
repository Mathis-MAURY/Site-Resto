/**
 * 
 * @param {HTMLElement} element: Bouton ajouter au panier 
 */
function ajouterAuPanier(element) {
    let id = parseInt(element.getAttribute("data-item-id"));
    // On fait une requête sur le fichier ajout_panier.php avec idProduit en paramètre GET qui est l'id du produit à ajouter
    fetch(`actions/ajout_panier.php?idProduit=${id}`).then(r => {
        // Quand on a la réponse c'est qu'il a été ajouté au panier donc on actualise la page, c'est rapide
        window.location.reload();
    });
}

/**
 * 
 * @param {HTMLElement} element: Bouton ajouter au panier 
 */
function supprimerDuPanier(element) {
    let id = parseInt(element.getAttribute("data-item-id"));

    // On fait une requête sur le fichier suppression_panier.php avec en paramètre GET l'id du produit à retirer
    fetch(`actions/suppression_panier.php?idProduit=${id}`).then(r => {
        // Quand on a la réponse on joue l'animation de suppression
        element.parentElement.classList.add("deleting");
        element.parentElement.addEventListener("animationend", () => {
            // Quand l'animation est finie, on actualise la page (ça évite d'actualiser que le panier), et c'est rapide
            window.location.reload();
        });
    });

    return;
}


document.querySelectorAll("#popup-type-conso .mode").forEach(mode => {
    mode.addEventListener("click", () => {
        document.querySelectorAll("#popup-type-conso .mode").forEach(temp => {
            temp.classList.remove("selected");
        });

        mode.classList.add("selected");
        window.location.href = `payer.php?typeConso=${mode.getAttribute("data-type-conso")}`;
    });
});

function showPopup() {
    document.getElementById("popup-type-conso").style.display = "flex";
}