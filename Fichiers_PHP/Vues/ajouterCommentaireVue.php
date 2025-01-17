<?php
require '../Controleurs/joueursControleur.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controleur = new controleurJoueurs();
    $numLicence = $_POST['licence'];
    $controleur->addCommentaire($numLicence,$_POST['commentaire']);

    header("Location: page_joueursVue.php");
    exit();
}

if (isset($_GET['licence'])) {
    // Récupérer le numéro de licence du joueur à supprimer
    $numLicence = $_GET['licence'];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body class='body-authentification'>
    <div class='authentification-container'>
        <h1>Ajouter un commentaire</h1>
        <form action="ajouterCommentaireVue.php" method="POST">
            <div class='players-table'>
                <input type="hidden" name="licence" value="<?php echo $numLicence; ?>" />
                <textarea name="commentaire" rows="7" cols="55" id="" maxlength="200"></textarea>
                <input class='players-table' type="submit" value="Valider" />
                <a href="page_joueursVue.php">
                    <input class='supp' type="button" value="Annuler" />
                </a>
            </div>
        </form>
    </div>
</body>
</html>
