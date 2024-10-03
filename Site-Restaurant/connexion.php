<?php
  $pageTitle = "Connexion";
  include 'fonctions/header.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashMeal - Connexion à votre compte</title>
    <link rel="stylesheet" href="css/connexion.css">
</head>

<body>

    <form action="" method="POST" class="form_connexion_inscription">
        <h2>BIENVENUE !</h2>
        <p class="welcome">
           Connectez vous à votre compte <span class="hint">FlashMeal</span>, et venez passer votre commande
        </p>
       
        <p class="separator"></p>

        <label> Login </label>
        <input type="login" name="login" required value="">

        <p class="separator"></p>
        
        <label> Mot de passe</label>
        <input type="password" name="password" required value="">
        
        <p class="separator"></p>
        
            <input type="submit" name="submit" value="Connexion">
    </form>

</body>

</html>

<?php include 'fonctions/footer.php'; ?>
