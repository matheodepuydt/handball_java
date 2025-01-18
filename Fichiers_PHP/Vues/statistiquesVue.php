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
        <?php
        $controleur = new controleurStat();
        $nbVictoires = $controleur->getNbVictoires()['total'];
        $nbDefaites = $controleur->getNbDefaites()['total'];
        $nbNuls = $controleur->getNbNuls()['total'];
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
        echo "Pourcentage de Nuls : " . round($pourcentageNuls, 2) . "%<br>";
        
        ?>
    </div>
</body>
</html>  