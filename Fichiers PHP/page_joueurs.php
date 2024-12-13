<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <link rel="stylesheet" href="<?php echo __DIR__ . '/Fichiers_HTML_CSS/styles.css'; ?>">
</head>
<body class="body-page_joueurs">
    <?php
    session_start();
    include(__DIR__ . '/Fichiers_HTML_CSS/header.html');
    ?>

    <div class="div-page_joueurs">
        <h1>Joueurs</h1>
        <label for="joueurs">Liste des joueurs :</label>

        <table class = "table-page_joueurs">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Statut</th>
                    <th>Numéro de licence</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les données des joueurs seront ajoutées ici -->
                 <tr>
                    <th>Beth</th>
                    <td>Maxence</td>
                    <td>18</td>
                    <td>178</td>
                    <td>71</td>
                    <td>Actif</td>
                    <td>1652579226</td>
                 </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
