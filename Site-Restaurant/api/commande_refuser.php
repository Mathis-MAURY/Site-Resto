<?php
include dirname(__DIR__) . "/fonctions/ConnexionBDD.php";
include dirname(__DIR__) . "/fonctions/ReponseJson.php";
$connexionBdd = new ConnexionBDD();

// Pour firefox on précice que le formattage est en format json
header("Content-Type: application/json");

// Si l'ID de commande est manquant, le script renvoie une réponse JSON indiquant l'erreur, puis le script se termine.
if (!isset($_GET["id_commande"])) {
    ReponseJson::repondre([
        "succes" => false,
        "erreur" => "Vous devez fournir un id de commande avec le parametre URL ?id_commande=XX"
    ]);
}

$commande = $_GET["id_commande"];
// On vérifie si l'ID de commande existe dans la base 
if (!$connexionBdd->prepareAndFetchOne("SELECT * FROM commande WHERE id_commande = :id_commande", [":id_commande" => $commande])) {
    ReponseJson::repondre([
        "succes" => false,
        "erreur" => "La commande $commande est inexistante"
    ]);
}

// On update l'état de l'id commande ce qui représente l'état quand la commande est réfusé
$connexionBdd->prepareAndFetchOne(
    "UPDATE commande SET id_etat = 3 where id_commande = :id_commande",
    [
        ":id_commande" => $commande
    ]
);

//Après la mise à jour réussie, le script renvoie une réponse JSON indiquant le succès de l'opération.
ReponseJson::repondre([
    "succes" => true,
    "message" => "La commande $commande est refuser"
]);