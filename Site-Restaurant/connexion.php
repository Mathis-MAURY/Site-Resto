<?php
$pageTitle = "Connexion";
include 'fonctions/header.php';
include 'fonctions/ConnexionBDD.php';

session_start();

    $dbh = db_connect();

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer le nom d'utilisateur et le mot de passe
        $login = $dbh->real_escape_string($_POST['login']);
        $password = $_POST['password'];
    
        // Requête pour récupérer le mot de passe haché
        $result = $dbh->query("SELECT password FROM user WHERE login = '$login'");
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = $login;
                header("Location: commander.php");
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }

      //  $result->free(); 
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
           
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
     </form>

</body>

</html>

<?php include 'fonctions/footer.php'; ?>
