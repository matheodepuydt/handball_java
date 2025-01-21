<?php
    require '../Controleurs/matchsControleur.php';
    require '../Controleurs/redirectionControleur.php';
    
    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données du formulaire
        $poste = htmlspecialchars($_POST['poste']);
        $num_licence = htmlspecialchars($_POST['num_licence']);

        header("Location: feuilleDeMatchVue.php?poste=" . urlencode($poste) . "&num_licence=" . urlencode($num_licence));
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
    <title>Changer de poste</title>
</head>
<body>
    <?php include('../static/header.html'); ?>
    
<div class='form-ajouter-match-container'>
        <h1>Changer de poste</h1>
        <form action='' method='post'>

            <input class="input-ajouter-match" type="hidden" name="date_heure" id="date_heure" value=
            '<?php echo htmlspecialchars($date_heure); ?>' required />

            <label class='label-ajouter-match' for='poste'>Choisir un nouveau Poste :</label>
            <select class='select-ajouter-joueur' name='poste'>
            <option value='Gardien' <?php echo ($participer && $participer->getPoste() == 'Gardien') ? 'selected' : ''; ?>>Gardien</option>
                <option value='Ailier gauche'. <?php echo ($participer && $participer->getPoste() == 'Ailier gauche') ? 'select' : ''; ?>>Ailier gauche</option>
                <option value='Arrière gauche'. <?php echo ($participer && $participer->getPoste() == 'Arrière gauche') ? 'select' : ''; ?>>Arrière gauche</option>
                <option value='Demi centre'. <?php echo ($participer && $participer->getPoste() == 'Demi centre') ? 'select' : ''; ?>>Demi centre</option>
                <option value='Arrière droit'. <?php echo ($participer && $participer->getPoste() == 'Arrière droit') ? 'select' : ''; ?>>Arrière droit</option>
                <option value='Ailier droit'. <?php echo ($participer && $participer->getPoste() == 'Ailier droit') ? 'select' : ''; ?>>Ailier droit</option>
                <option value='Pivot'. <?php echo ($participer && $participer->getPoste() == 'Pivot') ? 'select' : ''; ?>>Pivot</option>
            </select>

            <input class="input-ajouter-match" type="hidden" name="num_licence" id="num_licence" value=
            '<?php echo htmlspecialchars($licence); ?>' required />

            
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