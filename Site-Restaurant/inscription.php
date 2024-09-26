<?php
  $pageTitle = "Inscription";
  include 'fonctions/header.php';
?>

<section>
  <h1>Inscription</h1>
  <form action="connexion.php" method="post">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required> <br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required> <br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">S'inscrire</button>
  </form>
</section>

<?php include 'fonctions/footer.php'; ?>
