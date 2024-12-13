<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="/Projet PHP/php_handball/Fichiers_PHP/static/style.css">
</head>
<body class="body-authentification">
    <div class="authentification-container">
        <h1>Authentification</h1>
        <form action="authentification.php" method="post" class="form-authentification">
            <label class="label-authentification" for="login">Nom d'utilisateur :</label>
            <input class="input-authentification-login" type="text" id="login" name="login" required>

            <label class="label-authentification" for="password">Mot de passe :</label>
            <input class="input-authentification-password" type="password" id="password" name="password" required>

            <!-- Conteneur des messages d'erreur -->
            <?php if (isset($error_message)) : ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <input class="btn-submit" type="submit" name="seConnecter" value="Se connecter">
        </form>
    </div>
</body>
</html>

<?php

// Connexion à la base de données
$server = 'localhost';
$bd = 'phphandball';
$db_login = 'admin';
$db_password = '$iutinfo';

// Initialiser le message d'erreur
$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($login) || empty($password)) {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $db_login, $db_password);
        $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête
        $stmt = $linkpdo->prepare('SELECT password FROM authentification WHERE login = :login');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPassword = $result['password'];
            // Affiche le mot de passe haché pour le débogage
            var_dump($hashedPassword); 
            var_dump($password); 
            // Teste la vérification du mot de passe
            var_dump(password_verify($password, $hashedPassword)); 
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['user'] = $login;
                header('Location: matchs.php');
                exit();
            } else {
                $error_message = "Login ou mot de passe incorrect";
            }
        } else {
            $error_message = "Login ou mot de passe incorrect";
        }
    } catch (Exception $e) {
        $error_message = 'Erreur : ' . $e->getMessage();
    }
}
?>