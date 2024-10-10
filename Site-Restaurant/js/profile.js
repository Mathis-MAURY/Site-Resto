// On récupère le <div id="profile">
const profile = document.querySelector("aside#profile");

// On récupère le <div class="head"> du <div id="profile">
let profileHead = profile.querySelector("div.head");

// A chaque fois qu'on clique sur le module en haut à droite
profileHead.addEventListener("click", () => {
    // On lui ajoute (ou retire si elle est déjà présente) la classe "expand" qui le fait grossir
    profile.classList.toggle("expand");

    // On switch la flèche sur le côté du module de gauche vers bas ou de bas vers gauche selon le cas
    profile.querySelector("div.head div.right i").classList.toggle("fa-chevron-left");
    profile.querySelector("div.head div.right i").classList.toggle("fa-chevron-down");
});