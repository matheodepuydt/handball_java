<?php
    require_once '../classes/rencontre.php';
    require_once '../Controleurs/matchsControleur.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Ajouter un Match</title>
</head>
<body>
    <?php
        include('../static/header.html');
        session_start();
        
        // Initialisation des variables pour éviter des erreurs si le formulaire n'est pas soumis
        $date_heure = $nom_adversaire = $lieu = $domicile = $resultat = "";
        $match= null;

        // Traitement du formulaire si une soumission a été effectuée
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Récupération des données du formulaire en toute sécurité
            $date_heure = htmlspecialchars($_POST['date_heure']);
            $nom_adversaire = htmlspecialchars($_POST['nom_adversaire']);
            $lieu = htmlspecialchars($_POST['lieu']);
            $domicile = htmlspecialchars($_POST['domicile']);
            $resultat = htmlspecialchars($_POST['resultat']);

            
        // Vérification que la date_heure n'est pas vide
        if (empty($date_heure)) {
            echo "La date et l'heure ne peuvent pas être vides.";
            exit();
        }

            $match = new Rencontre($date_heure,$nom_adversaire,$lieu,$domicile,$resultat);
            $controleur = new matchsControleur();

            $controleur->addMatch($match);
            header("Location: matchsVue.php");
            exit(); // Important pour arrêter l'exécution après la redirection

        }
    ?>
<div class='form-ajouter-match-container'>
        <h1>Ajouter un match</h1>
        <form action='' method='post'>

            <label class='label-ajouter-match' for='date_heure'>Date et Heure :</label>
            <input class="input-ajouter-match" type="datetime-local" name="date_heure" id="date_heure" value=
                '<?php echo htmlspecialchars($date_heure); ?>' required />


            <label class='label-ajouter-match' for='nom_adversaire'>Nom Adversaire :</label>
            <input class='input-ajouter-match' type='text' name='nom_adversaire' id='nom_adversaire' value=
                '<?php echo htmlspecialchars($nom_adversaire); ?>' required />
            

            <label class='label-ajouter-match' for='lieu'>Lieu :</label>
            <input class='input-ajouter-match' type='text' name='lieu' id='lieu' value=
                '<?php echo htmlspecialchars($lieu); ?>' required />
            

            <label class='label-ajouter-match' for='domicile'>Domicile :</label>
            <select class='select-ajouter-match' name='domicile' id='domicile'>
                <option value='domicile' <?php echo $domicile == 'domicile' ? 'selected' : ''; ?>>Domicile</option>
                <option value='exterieur' <?php echo $domicile == 'extérieur' ? 'selected' : ''; ?>>Extérieur</option>
            </select>
            
            <input class='input-ajouter-joueur' type='hidden' name='resultat' id='resultat' value=
                '<?php echo htmlspecialchars($resultat); ?>' />

            
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