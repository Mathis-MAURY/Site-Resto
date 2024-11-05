<?php
  $pageTitle = "Accueil";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/Accueil.css">

</head>
<body>
<header>
  <nav>
    <ul>
      <li><a href="menu.php">Menu</a></li>
      <li><a href="connexion.php">Connexion</a></li>
      <li><a href="inscription.php">Inscription</a></li>
    </ul>
  </nav>
</header>

<img src="images/FLASHMEAL.jpg" alt="LOGO" class="logo">

<body>
<section>
  <h1>Bienvenue sur <span style="color: #00A45B;">FlashMeal</span></h1>
</section> 

<?php include 'fonctions/footer.php'; ?>

