<?php
session_start();

// Vider le panier de la session (si vous l'avez stocké)
unset($_SESSION['panier']);

// Supprimer le cookie du panier
setcookie("panier", "", time() - 3600, "/"); // On définit un cookie avec une date d'expiration dans le passé

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou la page d'accueil
header("Location: index.php");
exit();
?>
