<?php
    require '../Controleurs/joueursControleur.php';


    if (!isset($_GET['date_heure'])) {
        die("Erreur : aucun match sélectionné !");
    } else {
        $date_heure = htmlspecialchars($_GET['date_heure']);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de match</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

    <?php
    session_start();
    include('../static/header.html');
    ?>
    
    <div class="players-page-container">
        <h1>Feuille de match</h1>
        <label for="joueurs">Titulaires :</label>

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

        <br>
        <br>

        <label for="joueurs">Remplaçants :</label>

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