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
        $nbVictoires = $controleur->getNbVictoires();
        echo "Nombre de Victoires :  ".$nbVictoires['total'];
        ?>
    </div>
</body>
</html>  