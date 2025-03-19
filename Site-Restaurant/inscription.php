<?php
$pageTitle = "Inscription";
include 'fonctions/header.php';
include 'fonctions/ConnexionBDD.php';
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
        <input type="password" id="password" name="password" required placeholder="************">

        <a href="connexion.php" class="sublink">Vous avez déjà un compte ?</a>

        <p class="separator"></p>

        <input type="submit" name="submit" value="Inscription">
    </form>
    <?php

    // Créer une instance de la classe ConnexionBDD
    $db = new ConnexionBDD();

    // Établir la connexion à la base de données
    $pdo = $db->connect();

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les données du formulaire
        $email = $_POST['email'] ?? null; // Utiliser l'opérateur null coalescent
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;

        // Vérifier que les champs ne sont pas vides
        if (!empty($email) && !empty($login) && !empty($password)) {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Préparer la requête d'insertion
                $stmt = $pdo->prepare('INSERT INTO user (email, login, password) VALUES (:email, :login, :password)');

                // Lier les paramètres aux valeurs
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':login', $login, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

                // Exécuter la requête
                $stmt->execute();

                echo "Inscription réussie !";
            } catch (PDOException $e) {
                echo 'Erreur lors de l\'inscription : ' . $e->getMessage();
            }
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }
    ?>
</body>

</html>

<?php include 'fonctions/footer.php'; ?>