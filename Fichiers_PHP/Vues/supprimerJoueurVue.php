<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controleur = new controleurJoueurs();
    //à finir
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
    <title>Confirmer la suppression</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body class='body-authentification'>
    <div class='authentification-container'>
        <h1>Êtes-vous sûr de vouloir supprimer ce joueur ?</h1>
        <p>Une fois supprimé, cette action ne pourra pas être annulée.</p>
        <form action="supprimerJoueurAction.php" method="POST">
            <div class='players-table'>
                <input type="hidden" name="licence" value="<?php echo $numLicence; ?>" />
                <input class='players-table' type="submit" value="Confirmer la suppression" />
                <a href="page_joueursVue.php">
                    <input class='supp' type="button" value="Annuler" />
                </a>
            </div>
        </form>
    </div>
</body>
</html>
