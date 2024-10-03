<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payer</title>
</head>

<body>
    <h1>Payer</h1>
    <p>Commande n° XXXX pour un montant de XX,XX €</p>

    <form action="confirmer.php">
        <label for="NrCarte">NrCarte :</label>
        <input type="number" id="NrCarte" name="NrCarte" maxlength="16" min="0000000000000000" max="9999999999999999" required><br><br>

        <label for="Date">Date d'expiration :</label>
        <input type="month" id="Date" name="Date" required><br><br>

        <label for="CCV">Cryptogramme (CVC) :</label>
        <input type="number" id="CCV"  name="CCV" min="000" max="999" required><br><br>

        <button type="submit">Valider</button>
        <button type="commander.php">Modifier la commande</button>
        <button type="reset">Annuler</button><br>
        
    </form>


</body>
</html>
