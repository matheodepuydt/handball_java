<?php
require '../Controleurs/matchsControleur.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controleur = new matchsControleur();
    $date_heure = $_POST['date_heure'];
    $controleur->deleteMatch($date_heure);
    header("Location: matchsVue.php");
    exit();
}

if (isset($_GET['date_heure'])) {
    // Récupérer la date_heure du matchs à supprimer
    $date_heure = $_GET['date_heure'];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer la suppression</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body class='body-authentification'>
    <div class='authentification-container'>
        <h1>Êtes-vous sûr de vouloir supprimer ce Match ?</h1>
        <p>Une fois supprimé, cette action ne pourra pas être annulée.</p>
        <form action="supprimerMatchVue.php" method="POST">
            <div class='matchs-table'>
                <input type="hidden" name="date_heure" value="<?php echo $date_heure; ?>" />
                <input class='matchs-table' type="submit" value="Confirmer la suppression" />
                <a href="matchsVue.php">
                    <input class='supp' type="button" value="Annuler" />
                </a>
            </div>
        </form>
    </div>
</body>
</html>
