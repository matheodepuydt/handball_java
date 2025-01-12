<?php
    require '../Controleurs/page_joueursControleur.php';
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
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Statut</th>
                    <th>Numéro de licence</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $controleur = new controleurJoueurs();
                $joueurs = $controleur->getAllJoueurs();

                foreach ($joueurs as $joueur) {
                    $numLicence = $joueur['num_licence'];
                    echo "<tr>
                            <td>{$joueur['nom']}</td>
                            <td>{$joueur['prenom']}</td>
                            <td>{$joueur['date_de_naissance']}</td>
                            <td>{$joueur['taille']}</td>
                            <td>{$joueur['poids']}</td>
                            <td>{$joueur['statut']}</td>
                            <td>{$joueur['num_licence']}</td>
                            <td>
                                <a href='modifierJoueurVue.php?licence={$numLicence}'>
                                    <button type='button'>Modifier le joueur</button>
                                </a>
                            </td>
                            <td><button type='submit' name='commentaire'>Ajouter un commentaire</button></td>                                
                            <td><button type='submit' name='supprimer'>Supprimer</button></td>
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