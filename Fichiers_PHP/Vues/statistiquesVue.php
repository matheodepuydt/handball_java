<?php
    require '../Controleurs/statistiquesControleur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <?php
    include('../static/header.html');  
    session_start();
    ?>
    <div class="players-page-container">
        <h1>Statistiques</h1>
        <h3>Équipe</h3>
        <?php
        $controleur = new controleurStat();
        $nbVictoires = $controleur->getNbVictoires();
        $nbDefaites = $controleur->getNbDefaites();
        $nbNuls = $controleur->getNbNuls();
        echo "Nombre de Victoires :  $nbVictoires<br>";
        echo "Nombre de Défaites :  $nbDefaites<br>";
        echo "Nombre de Matchs Nuls : $nbNuls<br><br>";

        $totalMatchs = $nbVictoires + $nbDefaites + $nbNuls;

        // Calcul des pourcentages
        $pourcentageVictoires = ($totalMatchs > 0) ? ($nbVictoires / $totalMatchs) * 100 : 0;
        $pourcentageDefaites = ($totalMatchs > 0) ? ($nbDefaites / $totalMatchs) * 100 : 0;
        $pourcentageNuls = ($totalMatchs > 0) ? ($nbNuls / $totalMatchs) * 100 : 0;

        // Affichage des résultats
        echo "Pourcentage de Victoires : " . round($pourcentageVictoires, 2) . "%<br>";
        echo "Pourcentage de Défaites : " . round($pourcentageDefaites, 2) . "%<br>";
        echo "Pourcentage de Matchs Nuls : " . round($pourcentageNuls, 2) . "%<br>";
        ?>
        <h3>Joueurs</h3>
        <table class="players-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Statut</th>
                    <th>Poste préféré</th>
                    <th>Titularisations</th>
                    <th>Remplacements</th>
                    <th>Note moyenne</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $joueurs = $controleur->getAllJoueurs();

                foreach ($joueurs as $joueur) {
                    $numLicence = $joueur['num_licence'];
                    $poste = $controleur->getPostePrefereJoueur($numLicence);
                    $titularisation = $controleur->getNbTitularisations($numLicence);
                    $remplacements = $controleur->getNbRemplacements($numLicence);
                    $moyenne = $controleur->getMoyenneNote($numLicence);
                    echo "<tr>
                            <td>{$joueur['nom']}</td>
                            <td>{$joueur['prenom']}</td>
                            <td>{$joueur['statut']}</td>
                            <td>$poste</td>
                            <td>$titularisation</td>
                            <td>$remplacements</td>
                            <td>$moyenne</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>  