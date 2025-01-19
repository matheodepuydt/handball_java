<?php
    require '../Controleurs/joueursControleur.php';
    require '../classes/joueur.php';
    require '../Controleurs/redirectionControleur.php';

    if (isset($_GET['feuille'])) {
        $feuille = $_GET['feuille'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

    <?php
    include('../static/header.html');
    ?>
    
    <div class="players-page-container">
        <h1>Sélection</h1>
        <label for="joueurs">Liste des joueurs :</label>

        <table class="players-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille(cm)</th>
                    <th>Poids(kg)</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $controleur = new controleurJoueurs();
                $joueurs = $controleur->getAllActifs();

                // Récupérer les numéros de licence des titulaires et remplaçants
                $titulairesLicences = array_map(function($joueur) {
                    return $joueur->getNum_licence();
                }, $_SESSION['titulaires']);
                
                $remplacantsLicences = array_map(function($joueur) {
                    return $joueur->getNum_licence();
                }, $_SESSION['remplacants']);
                
                foreach ($joueurs as $joueur) {
                    $numLicence = $joueur->getNum_licence();
                    
                    // Vérifier si le joueur est déjà dans les titulaires ou remplaçants
                    if (in_array($numLicence, $titulairesLicences) || in_array($numLicence, $remplacantsLicences)) {
                        continue; // Passer à l'itération suivante si le joueur est déjà dans les titulaires ou remplaçants
                    }

                    echo "<tr>
                            <td>{$joueur->getNom()}</td>
                            <td>{$joueur->getPrenom()}</td>
                            <td>{$joueur->getTaille()}</td>
                            <td>{$joueur->getPoids()}</td>
                            <td>
                                <a href='commentairesVue.php?licence=$numLicence'>
                                    <button type='button'>Commentaires</button>
                                </a>
                            </td>
                            <td>
                                <a href='notesVue.php?licence=$numLicence'>
                                    <button type='button'>Notes</button>
                                </a>
                            </td>
                            <td>
                                <a href='feuilleDeMatchVue.php?licence=$numLicence&feuille=$feuille'>
                                    <button type='button'>Choisir</button>
                                </a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-player-section">
            <a href="feuilleDeMatchVue.php">
                <input type="button" value="Retour"/>
            </a>
        </div>
    </div>
</body>
</html>  