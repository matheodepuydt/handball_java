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
                    echo "<tr>
                            <td><input type='hidden' name='nom' value='{$joueur['nom']}'>{$joueur['nom']}</td>
                            <td><input type='hidden' name='prenom' value='{$joueur['prenom']}'>{$joueur['prenom']}</td>
                            <td><input type='hidden' name='date_de_naissance' value='{$joueur['date_de_naissance']}'>{$joueur['date_de_naissance']}</td>
                            <td><input type='hidden' name='taille' value='{$joueur['taille']}'>{$joueur['taille']}</td>
                            <td><input type='hidden' name='poids' value='{$joueur['poids']}'>{$joueur['poids']}</td>
                            <td><input type='hidden' name='statut' value='{$joueur['statut']}'>{$joueur['statut']}</td>
                            <td><input type='hidden' name='licence' value='{$joueur['num_licence']}'>{$joueur['num_licence']}</td>
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