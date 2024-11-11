<?php
include dirname(__DIR__) . "/fonctions/ConnexionBDD.php";
include dirname(__DIR__) . "/fonctions/ReponseJson.php";
$connexionBdd = new ConnexionBDD();

// Pour Firefox, on précise que le formatage est en JSON
header("Content-Type: application/json");

// Vérifie si l'ID de commande est présent dans la requête
if (!isset($_GET["id_commande"])) {
    ReponseJson::repondre([
        "succes" => false,
        "erreur" => "Vous devez fournir un id de commande avec le paramètre URL ?id_commande=XX"
    ]);
    exit;
}

$idCommande = $_GET["id_commande"];

// Vérifie si la commande existe dans la base de données
$commande = $connexionBdd->prepareAndFetchOne(
    "SELECT * FROM commande WHERE id_commande = :idCommande",
    [":idCommande" => $idCommande]
);

if (!$commande) {
    ReponseJson::repondre([
        "succes" => false,
        "erreur" => "La commande $idCommande est inexistante !"
    ]);
    exit;
}

// Vérifie l'état actuel de la commande
$etatActuel = $commande['id_etat'];

// Si la commande est déjà terminée, renvoie un message de confirmation
if ($etatActuel == 1) {
    ReponseJson::repondre([
        "succes" => true,
        "message" => "La commande $idCommande est déjà terminée."
    ]);
    exit;
}

// Met à jour l'état de la commande pour la marquer comme terminée (id_etat = 1)
$miseAJour = $connexionBdd->prepareAndExecute(
    "UPDATE commande SET id_etat = 1 WHERE id_commande = :idCommande",
    [":idCommande" => $idCommande]
);

// Vérifie si la mise à jour a réussi
if ($miseAJour) {
    ReponseJson::repondre([
        "succes" => true,
        "message" => "La commande $idCommande a été marquée comme terminée."
    ]);
} else {
    ReponseJson::repondre([
        "succes" => false,
        "erreur" => "Échec de la mise à jour de la commande $idCommande. Elle pourrait déjà être terminée ou inexistante."
    ]);
}
?>
