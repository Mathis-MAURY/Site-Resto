<?php
include dirname(__DIR__) . "/fonctions/ConnexionBDD.php";
include dirname(__DIR__) . "/fonctions/ReponseJson.php";
$connexionBdd = new ConnexionBDD();

// Pour firefox on précice que le formattage est en format json
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
if (!($connexionBdd->prepareAndFetchOne("SELECT * FROM commande WHERE id_commande = :idCommande", [":idCommande" => $ID_commande]))) {
    ReponseJson::repondre([
        "success" => false,
        "erreur" => "La commande $ID_commande est inexistante !"
    ]);
}


// On update l'état de l'id commande ce qui représente l'état "en préparation"
$commandes = $connexionBdd->prepareAndFetchOne(
    "UPDATE commande SET id_etat = 1 WHERE id_commande = :idCommande;",
    [
        ":idCommande" => $ID_commande
    ]
);

//Après la mise à jour réussie, le script renvoie une réponse JSON indiquant le succès de l'opération.
ReponseJson::repondre([
    "success" => true,
    "message" => "La commande $ID_commande est maintenant acceptee !"
]);
