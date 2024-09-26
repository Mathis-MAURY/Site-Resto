<?php
    $pagetitle= "commander";
    include 'fonctions/fonctions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commander</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>MENU</h1>
    <form action="payer.php" method="post">
    <ul>
        <li>Pizza Bosca(17€)
        <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>Pizza Full Formaggi (15€)
        <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>Pizza Basta Cosi (14€)
        <input type="number" min="0" max="100" step="1" placeholder="2">
        </li>
        <li>Katsu viande et aubergines (14,90€)
        <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>Katsu poisson et aubergines (12,90€)
        <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>Coxinhas boeuf (9,90€)
        <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>Coxinhas vegan (7,90€)
        <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>Coxinhas fromage (7,90)
        <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
    </ul>
    <label class="radio-label">
        <input type="radio" name="commande" value="surplace">
        <span class="custom-radio"></span> Sur place
        <input type="radio" name="commande" value="emporter">
        <span class="custom-radio"></span> À emporter<br><br>
        <button type="submit">Commander</button>
        <a href="accueil.php">Annuler</a>
    </label>
    </form>
</body>
</html>