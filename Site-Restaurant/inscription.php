<?php
  $pageTitle = "Inscription";
  include 'fonctions/header.php';
  include 'fonctions/fonction.php';
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
        <input type="email" id="email" name="email" required placeholder="exemple@domaine.com">
        
        <p class="separator"></p>

        <label>Login</label>
        <input type="text" id="login" name="login" required placeholder="Votre identifiant">

        <p class="separator"></p>
        
        <label>Mot de passe</label>
        <input type="password" id="password" name="password" required>
        
        <a href="connexion.php" class="sublink">Vous avez déjà un compte ?</a>
        
        <p class="separator"></p>
        
            <input type="submit" name="submit" value="Inscription">
    </form>
    <?php 
    
    // Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Hacher le mot de passe pour plus de sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête SQL
    $sql = "INSERT INTO user (email, login, password) VALUES (:email, :login, :password)";
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres aux valeurs
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

    // Exécuter la requête et vérifier le succès
    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
    ?>
</body>

</html>

<?php include 'fonctions/footer.php'; ?>
