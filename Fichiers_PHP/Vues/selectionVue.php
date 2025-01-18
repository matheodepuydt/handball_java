<?php
    require '../Controleurs/joueursControleur.php';
    require '../classes/joueur.php'
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
    session_start();
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

                foreach ($joueurs as $joueur) {
                    $numLicence = $joueur->getNum_licence();
                    echo "<tr>
                            <td>{$joueur->getNom()}</td>
                            <td>{$joueur->getPrenom()}</td>
                            <td>{$joueur->getTaille()}</td>
                            <td>{$joueur->getPoids()}</td>
                            <td>
                                <a href='commentairesVue.php?licence={$numLicence}'>
                                    <button type='button'>Commentaires</button>
                                </a>
                            </td>
                            <td>
                                <a href='notesVue.php?licence={$numLicence}'>
                                    <button type='button'>Notes</button>
                                </a>
                            </td>
                            <td>
                                <a href='modifierJoueurVue.php?licence={$numLicence}'>
                                    <button type='button'>Choisir</button>
                                </a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>  