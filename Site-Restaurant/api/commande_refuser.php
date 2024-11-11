<?php
include dirname(__DIR__) . "/fonctions/ConnexionBDD.php";
include dirname(__DIR__) . "/fonctions/ReponseJson.php";
$connexionBdd = new ConnexionBDD();

// Pour Firefox, on précise que le formatage est en format JSON
header("Content-Type: application/json");

// Si l'ID de commande est manquant, le script renvoie une réponse JSON indiquant l'erreur, puis le script se termine.
if (!isset($_GET["id_commande"])) {
    ReponseJson::repondre([
        "success" => false,
        "erreur" => "Vous devez fournir un id de commande avec le parametre URL ?id_commande=XX"
    ]);
}

$ID_commande = $_GET["id_commande"];

// On vérifie si l'ID de commande existe dans la base 
$commande = $connexionBdd->prepareAndFetchOne(
    "SELECT * FROM commande WHERE id_commande = :idCommande",
    [":idCommande" => $ID_commande]
);

if (!$commande) {
    ReponseJson::repondre([
        "success" => false,
        "erreur" => "La commande $ID_commande est inexistante !"
    ]);
}

// Vérifier l'état actuel de la commande
$currentState = $commande['id_etat'];

// Si la commande est déjà dans l'état abandonné, on considère que le refus a déjà été fait
if ($currentState == 2) {
    ReponseJson::repondre([
        "success" => true,
        "message" => "La commande $ID_commande est deja refusee et marquee comme abandonnee."
    ]);
}

// Sinon, on met à jour l'état de la commande (en abandonné)
$updateQuery = "UPDATE commande SET id_etat = 2 WHERE id_commande = :idCommande";
$updateResult = $connexionBdd->prepareAndFetchOne($updateQuery, [":idCommande" => $ID_commande]);

// Vérifier si la mise à jour a été effectuée
if ($updateResult) {
    // Si la mise à jour a réussi, on renvoie une réponse JSON de succès
    ReponseJson::repondre([
        "success" => true,
        "message" => "La commande $ID_commande est maintenant refusee et marquee comme abandonnee."
    ]);
} else {
    // Si la mise à jour échoue, on renvoie une réponse JSON d'erreur
    ReponseJson::repondre([
        "success" => false,
        "erreur" => "Echec du refus de la commande $ID_commande. La commande pourrait deja être refusee ou n'existe pas."
    ]);
}
?>
