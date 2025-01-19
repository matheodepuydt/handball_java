<?php
    require '../Controleurs/matchsControleur.php';
    require '../Controleurs/redirectionControleur.php';
    
    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données du formulaire
        $note = htmlspecialchars($_POST['note']);
        $num_licence = htmlspecialchars($_POST['num_licence']);

        header("Location: feuilleDeMatchVue.php?note=" . urlencode($note) . "&num_licence=" . urlencode($num_licence));
        exit(); // Important pour arrêter l'exécution après la redirection

    }

    //On vérifie si une participation a bien été selectionnée
    if (!isset($_GET['date_heure']) || !isset($_GET['num_licence'])) {
        die("Erreur : mauvaise sélection !");
    } else {
        $controleur = new matchsControleur();
        $date_heure = htmlspecialchars($_GET['date_heure']);
        $licence = htmlspecialchars($_GET['num_licence']);
        $participer = $controleur->getParticipation($date_heure,$licence);
    }

    if (!$participer) {
        die("Erreur : le match n'existe pas !");
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Mettre une Note</title>
</head>
<body>
    <?php include('../static/header.html'); ?>
    
<div class='form-ajouter-match-container'>
        <h1>Mettre une Note</h1>
        <form action='' method='post'>

            <input class="input-ajouter-match" type="hidden" name="date_heure" id="date_heure" value=
            '<?php echo htmlspecialchars($participer->getDate()); ?>' required />

            <label class='label-ajouter-match' for='note'>Choix de la Note :</label>
            <select class='select-ajouter-joueur' name='note'>
                <option value='1'. <?php $participer->getNote() == '1' ? 'select' : ''; ?>>1</option>
                <option value='2'. <?php $participer->getNote() == '2' ? 'select' : ''; ?>>2</option>
                <option value='3'. <?php $participer->getNote() == '3' ? 'select' : ''; ?>>3</option>
                <option value='4'. <?php $participer->getNote() == '4' ? 'select' : ''; ?>>4</option>
                <option value='5'. <?php $participer->getNote() == '5' ? 'select' : ''; ?>>5</option>
            </select>

            <input class="input-ajouter-match" type="hidden" name="num_licence" id="num_licence" value=
            '<?php echo htmlspecialchars($participer->getNum_licence()); ?>' required />

            
            <div class='actions-ajouter-match'>
                <input class='input-ajouter-match' type='submit' value='Valider' />
                <a href='feuilleDeMatchVue.php'>
                    <input class='input-ajouter-match' type='button' value='Annuler' />
                </a>
            </div>
        </form>
    </div>
</body>
</html>