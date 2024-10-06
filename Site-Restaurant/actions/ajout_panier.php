<?php

include "../fonctions/ConnexionBDD.php"; // Inclut le fichier contenant la classe ConnexionBDD
$bdd = new ConnexionBDD(); // Crée une instance de la classe ConnexionBDD

if (!isset($_SESSION["user"])) { // Vérifie si l'utilisateur est connecté
    header("Location: login.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    die(); // Termine l'exécution du script
}

$panier = json_decode($_COOKIE["panier"] ?? "[]", true); // Décode le cookie 'panier' en un tableau PHP

if (isset($_GET["idProduit"])) { // Vérifie si un ID de produit est passé en paramètre GET
    $item = $bdd->prepareAndFetchOne( // Effectue une requête SQL préparée pour récupérer les informations du produit
        "SELECT * FROM produit WHERE produit.id_produit = :idProduit;",
        [
            ":idProduit" => intval($_GET["idProduit"]) // Convertit l'ID du produit en entier
        ]
    );

    if (empty($item)) { // Vérifie si le produit n'existe pas dans la base de données
        // Le produit n'existe pas.
        echo json_encode([
            "error" => "Produit non present." // Retourne un message d'erreur JSON si le produit n'est pas trouvé
        ], JSON_PRETTY_PRINT);
        return; // Termine l'exécution du script
    }

    // Recherche dans le panier, si un produit avec le même ID existe, augmente sa quantité
    // Sinon, ajoute le produit au panier avec une quantité de 1
    $found = FALSE;
    foreach ($panier as $key => $i) {
        if ($i["id_produit"] == $item["id_produit"]) {
            $panier[$key]["qty"] = intval($panier[$key]["qty"]) + 1; // Augmente la quantité du produit dans le panier
            $found = TRUE;
        }
    }

    if (!$found) {
        $panier[] = [ // Ajoute le produit au panier avec une quantité de 1 si le produit n'est pas déjà présent
            "id_produit" => $item["id_produit"],
            "qty" => 1
        ];
    }
}

setcookie("panier", json_encode($panier), time() + 72000, "/"); // Met à jour le cookie 'panier' avec le nouveau contenu et le temps d'expiration
