<?php
    require '../Controleurs/matchsControleur.php';
    session_start();
    
    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données du formulaire
        $date_heure = htmlspecialchars($_POST['date_heure']);
        $nom_adversaire = htmlspecialchars($_POST['nom_adversaire']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $domicile = htmlspecialchars($_POST['domicile']);
        $resultat = htmlspecialchars($_POST['resultat']);

        $match = new Rencontre($date_heure,$nom_adversaire,$lieu,$domicile,$resultat);
        $controleur = new matchsControleur();

        $controleur->modifierMatch($match);
        header("Location: matchsVue.php");
        exit(); // Important pour arrêter l'exécution après la redirection

    }

    if (!isset($_GET['date_heure'])) {
        die("Erreur : aucun match sélectionné !");
    } else {
        $date_heure = htmlspecialchars($_GET['date_heure']);

        $controleur = new matchsControleur();
        $match = $controleur->getMatch($date_heure);
    }

    if (!$match) {
        die("Erreur : le match n'existe pas !");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Modifier un Match</title>
</head>
<body>
    <?php include('../static/header.html'); ?>
    
<div class='form-ajouter-match-container'>
        <h1>Modifier un match</h1>
        <form action='' method='post'>

            <input class="input-ajouter-match" type="hidden" name="date_heure" id="date_heure" value=
                '<?php echo htmlspecialchars($match->getDate()); ?>' required />


            <label class='label-ajouter-match' for='nom_adversaire'>Nom Adversaire :</label>
            <input class='input-ajouter-match' type='text' name='nom_adversaire' id='nom_adversaire' value=
                '<?php echo htmlspecialchars($match->getAdversaire()); ?>' required />
            

            <label class='label-ajouter-match' for='lieu'>Lieu :</label>
            <input class='input-ajouter-match' type='text' name='lieu' id='lieu' value=
                '<?php echo htmlspecialchars($match->getLieu()); ?>' required />
            

            <label class='label-ajouter-match' for='domicile'>Domicile :</label>
            <select class='select-ajouter-match' name='domicile' id='domicile'>
                <option value='domicile' <?php echo $match->getDomicile() == 'domicile' ? 'selected' : ''; ?>>Domicile</option>
                <option value='exterieur' <?php echo $match->getDomicile() == 'extérieur' ? 'selected' : ''; ?>>Extérieur</option>
            </select>
            

            <label class='label-ajouter-match' for='resultat'>Résultat :</label>
            <input class='input-ajouter-match' type='text' name='resultat' id='resultat' value=
                '<?php echo htmlspecialchars($match->getResultat()); ?>' />

            
            <div class='actions-ajouter-match'>
                <input class='input-ajouter-match' type='submit' value='Valider' />
                <a href='matchsVue.php'>
                    <input class='input-ajouter-match' type='button' value='Annuler' />
                </a>
            </div>
        </form>
    </div>
</body>
</html>