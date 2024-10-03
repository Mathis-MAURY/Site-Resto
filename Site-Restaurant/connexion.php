<?php
$pageTitle = "Connexion";
include 'fonctions/header.php';
include 'fonctions/fonction.php';

session_start(); // Démarre la session

    $dbh = db_connect();

    // Récupérer le nom d'utilisateur et le mot de passe
    $login = $dbh->real_escape_string($_POST['login']);
    $password = $_POST['password'];

    // Requête pour récupérer le mot de passe haché
    $result = $dbh->query("SELECT login FROM user WHERE password = '$password'");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Vérifie le mot de passe
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = $login; // Stocke le nom d'utilisateur dans la session
            echo "Connexion réussie !";
            header("Location: dashboard.php"); // Exemple de redirection
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }

    // Fermer la connexion
    $dbh->close();
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
