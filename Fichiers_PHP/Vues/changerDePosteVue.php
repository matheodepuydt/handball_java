<?php
    require '../Controleurs/matchsControleur.php';
    require '../Controleurs/redirectionControleur.php';
    
    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données du formulaire
        $date_heure = htmlspecialchars($_POST['date_heure']);
        $nom_adversaire = htmlspecialchars($_POST['nom_adversaire']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $domicile = htmlspecialchars($_POST['domicile']);
        $resultat = htmlspecialchars($_POST['resultat']);

        $match = new Rencontre($date_heure,$nom_adversaire,$lieu,$domicile,$resultat);

        header("Location: matchsVue.php");
        exit(); // Important pour arrêter l'exécution après la redirection

    }

    //Vérification si un participer a bien été selectionné
    if (!isset($_GET['date_heure']) || !isset($_GET['licence'])) {
        die("Erreur : aucun match sélectionné !");
    } else {
        $controleur = new matchsControleur();
        $date_heure = htmlspecialchars($_GET['date_heure']);
        $licence = htmlspecialchars($_GET['licence']);
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
    <title>Changer de poste</title>
</head>
<body>
    <?php include('../static/header.html'); ?>
    
<div class='form-ajouter-match-container'>
        <h1>Changer de poste</h1>
        <form action='' method='post'>

            <input class="input-ajouter-match" type="hidden" name="date_heure" id="date_heure" value=
                '<?php echo htmlspecialchars($match->getDate()); ?>' required />


            <input class="input-ajouter-match" type="hidden" name="nom_adversaire" id="nom_adversaire" value=
                '<?php echo htmlspecialchars($match->getAdversaire()); ?>' required />
            

            <input class="input-ajouter-match" type="hidden" name="lieu" id="lieu" value=
                '<?php echo htmlspecialchars($match->getLieu()); ?>' required />

            <input class="input-ajouter-match" type="hidden" name="domicile" id="domicile" value=
                '<?php echo htmlspecialchars($match->getDomicile()); ?>' required />
            
            <label class='label-ajouter-match' for='resultat'>Resultat :</label>
            <select class='select-ajouter-joueur' name='poste'>
                <?php
                echo "<option value='Gardien'" . ($participer->getPoste() == 'Gardien' ? ' selected' : '') . ">Gardien</option>";
                echo "<option value='Ailier gauche'" . ($participer->getPoste() == 'Ailier gauche' ? ' selected' : '') . ">Ailier gauche</option>";
                echo "<option value='Arrière gauche'" . ($participer->getPoste() == 'Arrière gauche' ? ' selected' : '') . ">Arrière gauche</option>";
                echo "<option value='Demi centre'" . ($participer->getPoste() == 'Demi centre' ? ' selected' : '') . ">Demi centre</option>";
                echo "<option value='Arrière droit'" . ($participer->getPoste() == 'Arrière droit' ? ' selected' : '') . ">Arrière droit</option>";
                echo "<option value='Ailier droit'" . ($participer->getPoste() == 'Ailier droit' ? ' selected' : '') . ">Ailier droit</option>";
                echo "<option value='Pivot'" . ($participer->getPoste() == 'Pivot' ? ' selected' : '') . ">Pivot</option>";
                ?>
            </select>

            
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