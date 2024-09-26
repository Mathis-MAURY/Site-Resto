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
    <link rel="stylesheet" href="css/commander.css">
</head>
<body>
    <h1>MENU</h1><br>
    <form action="payer.php" method="post">
    <ul>
        <li>
            <span>Pizza Bosca (17€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>
            <span>Pizza Full Formaggi (15€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>
            <span>Pizza Basta Cosi (14€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="2">
        </li>
        <li>
            <span>Katsu viande et aubergines (14,90€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>
            <span>Katsu poisson et aubergines (12,90€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
        <li>
            <span>Coxinhas boeuf (9,90€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>
            <span>Coxinhas vegan (7,90€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="1">
        </li>
        <li>
            <span>Coxinhas fromage (7,90€)</span>
            <input type="number" min="0" max="100" step="1" placeholder="0">
        </li>
    </ul>
    <label class="radio-label">
        <input type="radio" name="commande" value="surplace">
        <span class="custom-radio"></span> Sur place<br><br>
        <input type="radio" name="commande" value="emporter">
        <span class="custom-radio"></span> À emporter<br><br>
        <button type="submit">Commander</button>&nbsp;&nbsp;&nbsp;
        <a href="index.php">Annuler</a>
    </label>
    </form>
</body>
</html>
