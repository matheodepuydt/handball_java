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

    <div>
        <h1>Joueurs</h1>
        <label for="joueurs">Liste des joueurs :</label>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Statut</th>
                    <th>Numéro de licence</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $controleur = new controleurJoueurs();
                $joueurs = $controleur->getAllJoueurs();

                foreach ($joueurs as $joueur) {
                    echo "<tr>
                            <form method='POST' action=''>
                                <td><input type='hidden' name='nom' value='{$joueur[0]}'>{$joueur[0]}</td>
                                <td><input type='hidden' name='prenom' value='{$joueur[1]}'>{$joueur[1]}</td>
                                <td><input type='hidden' name='age' value='{$joueur[2]}'>{$joueur[2]}</td>
                                <td><input type='hidden' name='taille' value='{$joueur[3]}'>{$joueur[3]}</td>
                                <td><input type='hidden' name='poids' value='{$joueur[4]}'>{$joueur[4]}</td>
                                <td><input type='hidden' name='statut' value='{$joueur[5]}'>{$joueur[5]}</td>
                                <td><input type='hidden' name='licence' value='{$joueur[6]}'>{$joueur[6]}</td>
                                <td><button type='submit' name='commentaire'>Ajouter un commentaire</button></td>
                                <td><button type='submit' name='supprimer'>Supprimer</button></td>
                            </form>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
            <div>
                <input type="button" value="Ajouter" />
            </div>
    </div>
</body>
</html>  