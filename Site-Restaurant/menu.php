<?php

$pageTitle = "Menu";
include 'fonctions/header.php';



function autoloader($className)
{
    include "fonctions/$className.php";
}

spl_autoload_register("autoloader");

$connexionBDD = new ConnexionBDD();
$plats = $connexionBDD->prepareAndFetchAll(
    "SELECT * FROM produit" );
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/Accueil.css">

</head>
<body>
<header>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="connexion.php">Connexion</a></li>
      <li><a href="inscription.php">Inscription</a></li>
    </ul>
  </nav>
</header>

<body>

<div class="container">
    <?php
    $i = 0;

    foreach ($plats as $plat) {
        $i++;

        $id = $plat["id_produit"];
        $libelle = $plat["libelle"];
        $prix = $plat["prix_ht"];
        $imageUrl = $plat["imageurl"];
        echo "
        <div class=\"item\" data-item-id=\"$id\">
            <img src=\"$imageUrl\" class=\"preview\">
            <div class=\"content\">
                <p class=\"name\">$libelle</p>
                <p class=\"description\"></p>                   
                <span>
                    Prix unitaire <span class=\"price\">" . number_format($prix, 2) . "€</span> 
                </span>
            </div>
        </div>"; // Assure-toi que le point-virgule est ici
    }
    ?>
</div>




<?php include 'fonctions/footer.php'; ?>