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

<body>

<div class="container">
    <?php
    $i = 0;

    foreach ($plats as $plat) {
        $i++;

        $id = $plat["id_produit"];
        $libelle = $plat["libelle"];
        $prix = $plat["prix_ht"];
        $imageUrl = $plat["imageUrl"];
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