<?php
  $pageTitle = "Accueil";
  include 'fonctions/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <title>Accueil</title>
</head>
<body>
  
<section>
  <h1>Bienvenue</h1>
  <p>Voici notre page d'accueil statique pour le moment, elle sera dynamique plus tard.</p>
</section>

<a href="commander.php" class="button">Faites une commande !</a><br><br>
<a href="deconnexion.php" class="button">Se deconnecter !</a><br><br>

<?php include 'fonctions/footer.php'; ?>
</body>
</html>
