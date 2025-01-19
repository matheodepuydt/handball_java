<?php

require '../Controleurs/redirectionControleur.php';

if (!isset($_GET['message']) || !isset($_GET['return'])) {
    die("Erreur : paramètres manquants !");
}

$message = htmlspecialchars($_GET['message']);
$returnUrl = htmlspecialchars($_GET['return']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Erreur</title>
</head>
<body>
    <div class='error-container'>
        <h1>Erreur</h1>
        <p><?php echo $message; ?></p>
        <a href="<?php echo $returnUrl; ?>" class="btn-retour">Retour</a>
    </div>
</body>
</html>