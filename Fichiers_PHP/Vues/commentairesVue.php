<?php
    require '../Controleurs/joueursControleur.php';
    require '../classes/commentaire.php';

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
    <title>Commentaires</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <?php
    session_start();
    include('../static/header.html');
    ?>
    <div class="matchs-page-container">
        <h1>Commentaires</h1>
        <label for="matchs">Liste des commentaires :</label>

        <table class="matchs-table">
        <thead>
            <tr>
                <th>Date et Heure</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $controleur = new controleurJoueurs();
            $commentaires = $controleur->getCommentaires($licence);
            
            foreach ($commentaires as $commentaire) {
                echo "<tr>
                        <td>{$commentaire->getDate()}</td>
                        <td>{$commentaire->getDescription()}</td>
                    </tr>";
            }
            
        ?>
        </tbody>
        </table>
        <div class="add-match-section">
            <a href="selectionVue.php">
                <input type="button" value="Retour"/>
            </a>
        </div>
    </div>
</body>
</html>
