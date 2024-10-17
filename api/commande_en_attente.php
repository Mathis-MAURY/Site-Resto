<?php
include "fonctions/ConnexionBDD.php";
include "fonctions/ReponseJson.php";
$connexionBdd = new ConnexionBDD();

// Sélectionner les commandes avec leurs lignes associées
$commandes = $connexionBdd->prepareAndFetchAll(
    "SELECT commande.*, ligne.*, produit.*, user.*
     FROM commande
     INNER JOIN ligne ON commande.id_commande = ligne.id_commande
     INNER JOIN produit ON ligne.id_produit = produit.id_produit
     INNER JOIN user ON commande.id_user = user.id_user
     WHERE commande.id_etat = 0;"
);

// Organiser les commandes par leur ID pour regrouper les lignes
$commandesGrouped = [];
foreach ($commandes as $commande) {
    $commandeId = $commande['id_commande'];
    if (!isset($commandesGrouped[$commandeId])) {
        // Si la commande n'existe pas dans le tableau regroupé, l'ajouter
        $commandesGrouped[$commandeId] = [
            'id_commande' => $commande['id_commande'],
            'id_user' => $commande['id_user'],
            'id_etat' => $commande['id_etat'],
            'date' => $commande['date'],
            'total_commande' => $commande['total_commande'],
            'type_conso' => $commande['type_conso'],
            'lignes' => [], // Initialiser un tableau pour les lignes de commande,
            'user' => [
                'login' => $commande["login"],
                'email' => $commande["email"]
            ]
        ];
    }
    // Ajouter la ligne à la commande correspondante dans le tableau regroupé
    $commandesGrouped[$commandeId]['lignes'][] = [
        'id_ligne' => $commande['id_ligne'],
        'id_produit' => $commande['id_produit'],
        'libelle_produit' => $commande["libelle"],
        'qte' => $commande['qte'],
        'total_ligne_ht' => $commande['total_ligne_ht']
    ];
}

// Convertir le tableau regroupé en un tableau simple pour la réponse JSON
$commandesGrouped = array_values($commandesGrouped);

header("Content-Type: application/json");
ReponseJson::repondre([
    "success" => true,
    "nbCommandes" => count($commandesGrouped),
    "commandes" => $commandesGrouped
]);