<?php
    require '../Controleurs/matchsControleur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <?php
    session_start();
    include('../static/header.html');
    ?>
    <div class="matchs-page-container">
        <h1>Matchs</h1>
        <label for="matchs">Liste des matchs :</label>

        <table class="matchs-table">
        <thead>
            <tr>
                <th>Date et Heure</th>
                <th>Nom de l'Adversaire</th>
                <th>lieu</th>
                <th>Domicile/ Exterieur</th>
                <th>Résultat</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $controleur = new matchsControleur();
            $matchs = $controleur->getAllMatchs();

            foreach ($matchs as $matchs) {
                $date_heure = $matchs->getDate();
                echo "<tr>
                        <td>{$matchs->getDate()}</td>
                        <td>{$matchs->getAdversaire()}</td>
                        <td>{$matchs->getLieu()}</td>
                        <td>{$matchs->getDomicile()}</td>
                        <td>{$matchs->getResultat()}</td>
                        <td>
                            <a href='modifierMatchVue.php?date_heure={$date_heure}'>
                                <button type='button'>Modifier</button>
                            </a>
                        </td>                               
                        <td>
                            <a href='supprimerMatchVue.php?date_heure={$date_heure}'>
                                <button type='button'>Supprimer</button>
                            </a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-match-section">
            <a href="ajouterMatchVue.php">
                <input type="button" value="Ajouter"/>
            </a>
        </div>
    </div>
</body>
</html>  