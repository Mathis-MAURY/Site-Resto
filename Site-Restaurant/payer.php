<?php
include "fonctions/ConnexionBDD.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$connexionBDD = new ConnexionBDD();
$messageErreur = "";

$panier = json_decode($_COOKIE["panier"] ?? "[]", true);
if(count($panier) == 0){
    header("Location: commander.php");
}

$totalCommande = $connexionBDD->calculerTotalPanier($panier);
$carte = $_POST["carte_bancaire"] ?? NULL;
$date = $_POST["date_exp"] ?? NULL;
$cryptogramme = $_POST["cryptogramme"] ?? NULL;
$nom = $_POST["nom_titulaire"] ?? NULL;

$typeConso = $_GET["typeConso"] ?? 1;

if (isset($_POST["submit"])) {
    if ($cryptogramme == NULL || mb_strlen($cryptogramme) != 3) {
        $messageErreur = "Le cryptogramme doit faire 3 caractères de long.";
    }

    if ($carte == NULL || mb_strlen($carte) != 19) {
        $messageErreur = "Le numéro de la carte doit faire 16 caractères de long.";
    }

    if ($nom == NULL || mb_strlen($nom) < 3) {
        $messageErreur = "Le nom doit faire plus de 3 caractères de longueur";
    }

    if (empty($messageErreur)) {
        $connexionBDD->insererCommandeEtProduitDepuisPanier($typeConso);
        header("Location: confirmer.php");
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payer</title>
    <link rel="stylesheet" href="css/payer.css">
</head>

<body>
    <img src="assets/images/log.png" alt="">
    <form action="" method="POST" class="form_payer">
        <h2>Payer</h2>
        <p>Commande d'un montant de <b>
                <span style="color: #00A45B;">
                    <?= number_format($totalCommande, 2) . "€" ?>
                </span>
            </b>
        </p>
        <?php
        if ($messageErreur != "") {
            echo "<p class=\"erreur\">$messageErreur</p>";
        }
        ?>
        <p class="separator"></p>
        <label> Nom du titulaire</label>
        <input type="text" name="nom_titulaire" value="<?= $nom ?>">
        <label> N° Carte </label>
        <input type="text" id="carte_bancaire" name="carte_bancaire" value="<?= $carte ?>">
        <label> Date d'expiration</label>
        <input id="date_exp" maxlength='5' placeholder="MM/YY" type="text" name="date_exp" value="<?= $date ?>">
        <label> Cryptogramme (CVC)</label>
        <input type="text" name="cryptogramme" value="<?= $cryptogramme ?>">
        <p class="separator"></p>

        <input type="submit" name="submit" value="Payer">
    </form>
    <a href="commander.php">Modifier la commande</a>

    <script src="/js/payer.js"></script>
</body>

</html>