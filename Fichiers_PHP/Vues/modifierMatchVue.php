<?php
    require '../Controleurs/joueursControleur.php';
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
    <?php
        include('../static/header.html');
        session_start();
        
        // Traitement du formulaire si une soumission a été effectuée
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Récupération des données du formulaire en toute sécurité
            $date_heure = htmlspecialchars($_POST['date_heure']);
            $nom_adversaire = htmlspecialchars($_POST['nom_adversaire']);
            $lieu = htmlspecialchars($_POST['lieu']);
            $domicile = htmlspecialchars($_POST['domicile']);
            $resultat = htmlspecialchars($_POST['resultat']);

            $match = new Rencontre($date_heure,$nom_adversaire,$lieu,$domicile,$nom_adversaire);
            $controleur = new matchControleur();

            $controleur->modifierMatch($match);
            header("Location: matchsVue.php");
            exit(); // Important pour arrêter l'exécution après la redirection

        }

        if (isset($_GET['date_heure'])) {
            $date_heure = htmlspecialchars($_GET['date_heure']);

            $controleur = new matchControleur();
            $match = $controleur->getMatch($date_heure);
        }
    ?>
<div class='form-ajouter-match-container'>
        <h1>Modifier un match</h1>
        <form action='' method='post'>

            <input class="input-ajouter-match" type="hidden" name="date_heure" id="date_heure" value=
                '<?php echo htmlspecialchars($match['date_heure']); ?>' required />


            <label class='label-ajouter-match' for='nom_adversaire'>Nom Adversaire :</label>
            <input class='input-ajouter-match' type='text' name='nom_adversaire' id='nom_adversaire' value=
                '<?php echo htmlspecialchars($match['nom_adversaire']); ?>' required />
            

            <label class='label-ajouter-match' for='lieu'>Lieu :</label>
            <input class='input-ajouter-match' type='text' name='lieu' id='lieu' value=
                '<?php echo htmlspecialchars($match['lieu']); ?>' required />
            

            <label class='label-ajouter-match' for='domicile'>Domicile :</label>
            <select class='select-ajouter-match' name='domicile' id='domicile'>
                <option value='domicile' <?php echo $match['domicile'] == 'Domicile' ? 'selected' : ''; ?>>Domicile</option>
                <option value='exterieur' <?php echo $match['domicile'] == 'Extérieur' ? 'selected' : ''; ?>>Extérieur</option>
            </select>
            

            <label class='label-ajouter-joueur' for='resultat'>Résultat :</label>
            <input class='input-ajouter-joueur' type='text' name='resultat' id='resultat' value=
                '<?php echo htmlspecialchars($match['resultat']); ?>' />

            
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