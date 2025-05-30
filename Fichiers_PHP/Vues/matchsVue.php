<?php
    require '../Controleurs/matchsControleur.php';
    require '../Controleurs/redirectionControleur.php';
    
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
                <th>Lieu</th>
                <th>Domicile/Exterieur</th>
                <th>Résultat</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $controleur = new matchsControleur();
            $matchs = $controleur->getAllMatchs();
            $dateActuelle = date('Y-m-d H:i'); // Date et heure actuelles

            foreach ($matchs as $matchs) {
                $date_heure = $matchs->getDate();
                $estPasse = strtotime($date_heure) < strtotime($dateActuelle); // Comparaison des dates

                echo "<tr>
                        <td>{$matchs->getDate()}</td>
                        <td>{$matchs->getAdversaire()}</td>
                        <td>{$matchs->getLieu()}</td>
                        <td>{$matchs->getDomicile()}</td>
                        <td>{$matchs->getResultat()}</td>
                        <td>
                            <a href='modifierMatchVue.php?date_heure={$date_heure}'>
                                <button type='button' " . ($estPasse ? "disabled" : "") . ">Modifier</button>
                            </a>
                        </td>
                        
                        <td>
                            <a href='supprimerMatchVue.php?date_heure={$date_heure}'>
                                <button type='button' " . ($estPasse ? "disabled" : "") . ">Supprimer</button>
                            </a>
                        </td>

                        <td>
                            <a href='ajouterResultatVue.php?date_heure={$date_heure}'>
                                <button type='button' " . (!$estPasse ? "disabled" : "") . ">Ajouter Resultat</button>
                            </a>
                        </td>

                        <td>
                            <a href='feuilleDeMatchVue.php?date_heure={$date_heure}'>
                                <button type='button'>Feuille de Match</button>
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
