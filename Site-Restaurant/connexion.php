<?php
$pageTitle = "Connexion";

// Autoload classes
function my_autoloader($class) {
    include "fonctions/$class.php";
}
spl_autoload_register('my_autoloader');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$erreur = "";
$inscriptionReussie = $_SESSION["inscriptionReussie"] ?? false;
unset($_SESSION["inscriptionReussie"]);

$db = new ConnexionBDD();

if (!empty($_POST["login"]) && !empty($_POST["password"])) {
    $login = $_POST["login"];
    $mdp = $_POST["password"];

    if ($db->login($login, $mdp)) {
        header("Location: commander.php");
        exit();

    } else {
        $erreur = "Login ou mot de passe incorrect.";
    }
}

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
           Connectez-vous à votre compte <span class="hint">FlashMeal</span>, et venez passer votre commande.
        </p>
       
        <p class="separator"></p>

        <label for="login">Login</label>
        <input type="text" name="login" id="login" required>

        <p class="separator"></p>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        
        <p class="separator"></p>
        
        <input type="submit" name="submit" value="Connexion">
           
        <?php if (!empty($erreur)) : ?>
            <p class="error"><?php echo htmlspecialchars($erreur); ?></p> <!-- Added htmlspecialchars for security -->
        <?php endif; ?>
    </form>

</body>

</html>

<?php include 'fonctions/footer.php'; ?>
