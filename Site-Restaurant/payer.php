<?php
    $pageTitle= "Payer";
    include 'fonctions/header.php';
?>
    <h1>Payer</h1>
    <p>Commande n° XXXX pour un montant de XX,XX €</p>

    <form action="confirmer.php">
        

        <label for="NrCarte">Numéro de carte bancaire :</label>
        <input type="text" id="NrCarte" name="NrCarte" maxlength="16" pattern="\d{16}" placeholder="1234 1234 1234 1234" required><br>
        <small>Le numéro de carte doit contenir exactement 16 chiffres.</small><br><br>


        <label for="Date">Date d'expiration :</label>
        <input type="month" id="Date" name="Date" pattern="\d{2}/\d{2}" placeholder="MM/AA" required><br><br>

        <label for="CCV">Cryptogramme (CVC) :</label>

        <input type="text" id="CCV"  name="CCV" maxlength="3" pattern="\d{3}" placeholder="123"required><br>
        <small>3 chiffres au dos de la carte</small><br><br>

        <button type="submit">Valider</button>
        <button type="commander.php">Modifier la commande</button>
        <button type="reset">Annuler</button><br>
    </form>

    <?php include 'fonctions/footer.php'; ?>



    
