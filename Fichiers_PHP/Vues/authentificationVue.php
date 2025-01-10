<?php
require_once '../Controleurs/authentificationControleur.php';
// Initialiser le message d'erreur
$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($login) || empty($password)) {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    } else {
        try {

            // Utiliser le contrôleur pour vérifier les identifiants
            $authCtrl = new authentificationControleur();

            if ($authCtrl->verifyPasswordByLogin($login, $password)) {
                // Connexion réussie
                session_start();
                $_SESSION['user'] = $login;
                header('Location: matchsVue.php');
                exit();
            } else {
                $error_message = "Login ou mot de passe incorrect";
            }
        } catch (Exception $e) {
            $error_message = 'Erreur : ' . $e->getMessage();
        }
    }
}
?>

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
        <form action="authentificationVue.php" method="post" class="form-authentification">
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