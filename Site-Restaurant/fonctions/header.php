<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Remplace par ton nom d'utilisateur MySQL
$password = "";  // Remplace par ton mot de passe MySQL
$dbname = "db_restoweb";

// Crée la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="commander.php">Commander</a></li>
      <li><a href="connexion.php">Connexion</a></li>
      <li><a href="inscription.php">Inscription</a></li>
    </ul>
  </nav>
</header>
<main>
