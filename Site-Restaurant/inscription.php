<?php
  $pageTitle = "Inscription";
  include 'fonctions/header.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/inscription.css">
</head>

<body>
    <img src="assets/images/log.png" alt="">
    <form action="" method="POST" class="form_connexion_inscription">
        <h2>INSCRIVEZ-VOUS</h2>
        <p class="welcome">
            Remplissez les champs ci-dessous pour créer votre compte <span style="color: #00A45B;">FlashMeal </span> !
        </p>
       
        <p class="separator"></p>

        <label> Adresse e-mail </label>
        <input type="email" name="email" required value="">
        
        <p class="separator"></p>

        <label> Login</label>
        <input type="login" name="login" required value="">

        <p class="separator"></p>
        
        <label> Mot de passe</label>
        <input type="password" name="password" required value="">
        
        <a href="connexion.php" class="sublink">Vous avez déjà un compte ?</a>
        
        <p class="separator"></p>
        
            <input type="submit" name="submit" value="Inscription">
    </form>

</body>

</html>

<?php include 'fonctions/footer.php'; ?>
