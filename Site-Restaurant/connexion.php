<?php
  $pageTitle = "Connexion";
  include 'fonctions/header.php';
?>

<section>
  <h1>Connexion</h1>
  <form action="commander.php" method="post">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
  </form>
</section>

<?php include 'fonctions/footer.php'; ?>
