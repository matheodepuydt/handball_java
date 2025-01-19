<?php
    require '../Controleurs/joueursControleur.php';
    require '../classes/joueur.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

    <?php
    session_start();
    include('../static/header.html');
    ?>
    
    <div class="players-page-container">
        <h1>Joueurs</h1>
        <label for="joueurs">Liste des joueurs :</label>

        <table class="players-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Taille(cm)</th>
                    <th>Poids(kg)</th>
                    <th>Statut</th>
                    <th>Numéro de licence</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $controleur = new controleurJoueurs();
                $joueurs = $controleur->getAllJoueurs();

                foreach ($joueurs as $joueur) {
                    $numLicence = $joueur->getNum_licence();
                    echo "<tr>
                            <td>{$joueur->getNom()}</td>
                            <td>{$joueur->getPrenom()}</td>
                            <td>{$joueur->getDate_de_naissance()}</td>
                            <td>{$joueur->getTaille()}</td>
                            <td>{$joueur->getPoids()}</td>
                            <td>{$joueur->getStatut()}</td>
                            <td>{$joueur->getNum_licence()}</td>
                            <td>
                                <a href='ajouterCommentaireVue.php?licence={$numLicence}'>
                                    <button type='button'>Ajouter un commentaire</button>
                                </a>
                            </td>
                            <td>
                                <a href='modifierJoueurVue.php?licence={$numLicence}'>
                                    <button type='button'>Modifier</button>
                                </a>
                            </td>
                            <td>
                                <a href='supprimerJoueurVue.php?licence={$numLicence}'>
                                    <button type='button'>Supprimer</button>
                                </a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
            <div class="add-player-section">
                <a href="ajouterJoueurVue.php">
                    <input type="button" value="Ajouter"/>
                </a>
            </div>
    </div>
</body>
</html>  