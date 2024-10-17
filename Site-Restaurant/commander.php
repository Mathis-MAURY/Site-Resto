<?php
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function autoloader($className)
{
    include "fonctions/$className.php";
}

spl_autoload_register("autoloader");

$connexionBDD = new ConnexionBDD();
$plats = $connexionBDD->prepareAndFetchAll(
    "SELECT * FROM produit"
);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flushmeal</title>
    <link rel="stylesheet" href="css/commander.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <a href="index.php"><img class="retour" src="images/RETOUR.png" alt="Retour à la page d'accueil"></a>
        <img class="logo" src="images/FLASHMEAL.jpg">
    </header>
    <aside id="profile">
        <div class="head">
            <div class="left">
                Barre d'outils
            </div>
            <div class="right">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
        </div>

        <div class="controls">
            <a href="deconnexion.php" class="logout">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                Déconnexion
            </a>
        </div>
    </aside>
    <aside id="cart">
        <div class="head">
            <p class="title">Panier</p>
        </div>
        <div class="content">

            <?php
            $montantTotalPanier = 0;

            $panier = json_decode($_COOKIE["panier"] ?? "[]", true);

            foreach ($panier as $item) {
                $idProduit = $item["id_produit"];
                $quantity = $item["qty"];

                $produit = recupererInfosProduit($idProduit, $plats);
                if ($produit) {
                    $libelle = $produit["libelle"];
                    $prix = number_format($produit["prix_ht"] * $quantity, 2);
                    $montantTotalPanier += $produit["prix_ht"] * $quantity;

                    echo "
                        <div class=\"item\">
                        <input type=\"text\" value=\"$quantity x\" disabled>
                        <p class=\"name\">$libelle</p>
                        <p class=\"price\">{$prix}€</p>

                        <a class=\"delete\" data-item-id=\"$idProduit\" onclick=\"supprimerDuPanier(this)\" href=\"javascript:void(0);\">
                            <i style=\"text-align: center;\" class=\"fa-solid fa-x\"></i>
                        </a>
                    </div>
                        ";
                }
            }

            function recupererInfosProduit(int $idProduit, array $produits): array
            {

                foreach ($produits as $produit) {
                    if ($produit["id_produit"] == $idProduit)
                        return $produit;
                }

                return [];
            }
                ?>

        </div>
        <div class="bottom">
            <button onclick="showPopup();">Payer !
                <span class="price">
                    <?= "(" . number_format($montantTotalPanier, 2) . "€ H.T)" ?>
                </span>
            </button>
        </div>
    </aside>


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

                        <p class=\"bottom\">
                            <button class=\"ajoutPanier\" data-item-id=\"$id\" onclick=\"ajouterAuPanier(this)\">
                                <i class=\"fa-solid fa-cart-shopping\"></i>
                                <span>
                                    Ajout au panier <span class=\"price\">" . number_format($prix, 2) . "</span> 
                                </span>                        
                            </button>
                        </p>
                    </div>
                </div>
            ";
        }
        ?>
    </div>

    <div id="popup-type-conso" style="display: none;">
        <div class="wrapper">
            <p class="title">Choisissez un moyen de livraison</p>

            <div class="mode" data-type-conso="1">
                <img src="https://img.icons8.com/?size=256&id=543&format=png">
                Sur place
            </div>
            <div class="mode" data-type-conso="2">
                <i class="fas fa-shipping-fast"></i>
                A emporter
            </div>
        </div>
    </div>
    <script src="js/profile.js"></script>
    <script src="js/panier.js"></script>
</body>

</html>