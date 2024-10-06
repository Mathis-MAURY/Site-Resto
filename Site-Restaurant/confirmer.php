<?php
include "fonctions/ConnexionBDD.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    die();
}
$messageerreur = "";

if(!isset($_SESSION["idDeCommandeDernierementInseree"])){
    header("Location: commander.php");
    die();
}

$idCommande = $_SESSION["idDeCommandeDernierementInseree"];

$connexion = new ConnexionBDD();
$totalCommande = $connexion->prepareAndFetchOne(
    "SELECT commande.total_commande FROM commande WHERE commande.id_commande = :idCommande;",
    [
        ":idCommande" => $idCommande
    ]
);
$totalCommande = $totalCommande["total_commande"];
unset($_SESSION["idDeCommandeDernierementInseree"]);
setcookie("panier", "[]", time() + 72000, "/");

function my_autoloader($ConnexionBDD)
{
    include 'fonctions/' . $ConnexionBDD . '.php';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5; url=commander.php">

    <link href="assets/css/login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Confirmation de votre commande</title>
</head>

<body>

    <h1>Confirmation de commande</h1>

    <p style="font-weight: bold;">Merci pour votre commande <b>#<?= $idCommande ?></b>!</p>
    <p style="text-align: center;">Votre paiement d'un montant de <b><?= $totalCommande ?></b>€ a été effectué avec succès. <br>
    Votre commande est en cours de préparation. <br>
    Vous serez notifié par e-mail lorsque votre commande sera prête.</p>
    <p>Merci <i class="fa-regular fa-thumbs-up"></i></p>

    <a href="commander.php">Revenir à la page d'accueil</a>

</body>

</html>