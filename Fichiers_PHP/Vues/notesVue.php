<?php
    require '../Controleurs/matchsControleur.php';
    require '../Controleurs/redirectionControleur.php';

    if (isset($_GET['feuille'])) {
        $feuille = $_GET['feuille'];
    }

    if (!isset($_GET['licence'])) {
        die("Erreur : aucun match sélectionné !");
    } else {
        $licence = htmlspecialchars($_GET['licence']);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <?php
    include('../static/header.html');
    ?>
    <div class="matchs-page-container">
        <h1>Notes</h1>
        <label for="notes">Notes des précédents matchs :</label>

        <table class="matchs-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Adversaire</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $controleur = new matchsControleur();
            $notes = $controleur->getNotes($licence);
            $dateActuelle = date('Y-m-d H:i'); // Date et heure actuelles
            
            foreach ($notes as $note) {
                $estPasse = strtotime($note['date_heure']) < strtotime($dateActuelle); // Comparaison des dates
                if($estPasse){
                    echo "<tr>
                        <td>{$note['date_heure']}</td>
                        <td>{$note['nom_adversaire']}</td>
                        <td>{$note['note']}</td>
                    </tr>";
                }
            }
        ?>
        </tbody>
        </table>
        <div class="add-match-section">
            <a href="selectionVue.php?feuille=<?php $feuille ?>">
                <input type="button" value="Retour"/>
            </a>
        </div>
    </div>
</body>
</html>
