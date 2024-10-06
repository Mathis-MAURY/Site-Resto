<?php

include "../fonctions/ConnexionBDD.php"; // Inclut le fichier contenant la classe ConnexionBDD
$bdd = new ConnexionBDD(); // Crée une instance de la classe ConnexionBDD

$panier = json_decode($_COOKIE["panier"] ?? "[]", true); // Décode le cookie 'panier' en un tableau PHP

if(!isset($_SESSION["user"])){
    header("Location: login.php"); // Redirige vers la page de login si l'utilisateur n'est pas connecté
    die(); // Termine le script
}
if (isset($_GET["idProduit"])) {
    $idProduit = intval($_GET["idProduit"]);  // Récupération de l'identifiant du produit et conversion en entier

// Parcours du panier pour trouver et supprimer le produit correspondant à l'identifiant fourni
    foreach ($panier as $key => $item) {
        if ($item["id_produit"] == $idProduit) {
            unset($panier[$key]); 
        }
    }
}
// Mise à jour du cookie "panier" avec le nouveau contenu du panier (après suppression éventuelle)
// Le cookie est défini pour une durée de 72000 secondes (20 heures)
setcookie("panier", json_encode($panier), time() + 72000, "/"); 
