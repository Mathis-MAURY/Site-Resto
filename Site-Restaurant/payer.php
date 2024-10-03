<?php
    $pageTitle= "Payer";
    include 'fonctions/header.php';
?>
    <h1>Payer</h1>
    <p>Commande n° XXXX pour un montant de XX,XX €</p>

    <form action="confirmer.php">
<<<<<<< HEAD
        <label for="NrCarte">NrCarte :</label>
        <input type="number" id="NrCarte" name="NrCarte" maxlength="16" min="0000000000000000" max="9999999999999999" required><br><br>
=======
        <label for="NrCarte">Numéro de carte bancaire :</label>
        <input type="text" id="NrCarte" name="NrCarte" maxlength="16" pattern="\d{16}" placeholder="1234 1234 1234 1234" required><br>
        <small>Le numéro de carte doit contenir exactement 16 chiffres.</small><br><br>
>>>>>>> f816bef7545f1a3c034cf0f1a448743fffd7591d

        <label for="Date">Date d'expiration :</label>
        <input type="month" id="Date" name="Date" pattern="\d{2}/\d{2}" placeholder="MM/AA" required><br><br>

        <label for="CCV">Cryptogramme (CVC) :</label>
<<<<<<< HEAD
        <input type="number" id="CCV"  name="CCV" min="000" max="999" required><br><br>
=======
        <input type="text" id="CCV"  name="CCV" maxlength="3" pattern="\d{3}" placeholder="123"required><br>
        <small>3 chiffres au dos de la carte</small><br><br>
>>>>>>> f816bef7545f1a3c034cf0f1a448743fffd7591d

        <button type="submit">Valider</button>
        <button type="commander.php">Modifier la commande</button>
        <button type="reset">Annuler</button><br>
    </form>

    <?php include 'fonctions/footer.php'; ?>
