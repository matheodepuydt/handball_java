<?php
    //require '../classes/joueur.php';
    require '../Controleurs/modifierJoueurControleur.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Modifier joueur</title>
</head>
<body>
    <?php
    include('../static/header.html');
    session_start();
    
    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Récupération des données du formulaire en toute sécurité
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date_de_naissance = htmlspecialchars($_POST['date_de_naissance']);
        $taille = htmlspecialchars($_POST['taille']);
        $poids = htmlspecialchars($_POST['poids']);
        $statut = htmlspecialchars($_POST['statut']);
        $numLicence = htmlspecialchars($_POST['num_licence']);

        $joueur = new Joueur($nom,$prenom,$date_de_naissance,$taille,$poids,$numLicence,$statut);
        $controleur = new controleurModifierJoueur();

        $controleur->modifierJoueur($joueur);
        header("Location: page_joueursVue.php");
        exit(); // Important pour arrêter l'exécution après la redirection

    }

    if (isset($_GET['licence'])) {
        $numLicence = htmlspecialchars($_GET['licence']);

        $controleur = new controleurModifierJoueur();
        $joueur = $controleur->getJoueur($numLicence);

        // Utilisez ce numéro de licence pour récupérer les informations du joueur
        echo "Modification du joueur avec la licence : $numLicence";
    }
    ?>
    <div class='form-ajouter-joueur-container'>
        <h1>Modifier un joueur</h1>
        <form action='' method='post'>

            <input class="input-ajouter-joueur" type="hidden" name="num_licence" id="num_licence" value='<?php echo htmlspecialchars($joueur['num_licence']); ?>' required />

            <label class='label-ajouter-joueur' for='nom'>Nom :</label>
            <input class='input-ajouter-joueur' type='text' name='nom' id='nom' value='<?php echo htmlspecialchars($joueur['nom']); ?>' required />
            
            <label class='label-ajouter-joueur' for='prenom'>Prénom :</label>
            <input class='input-ajouter-joueur' type='text' name='prenom' id='prenom' value='<?php echo htmlspecialchars($joueur['prenom']); ?>' required />
            
            <label class='label-ajouter-joueur' for='date_de_naissance'>Date de naissance :</label>
            <input class='input-ajouter-joueur' type='date' name='date_de_naissance' id='date_de_naissance' value='<?php echo htmlspecialchars($joueur['date_de_naissance']); ?>' />
            
            <label class='label-ajouter-joueur' for='taille'>Taille (cm) :</label>
            <input class='input-ajouter-joueur' type='number' name='taille' id='taille' value='<?php echo htmlspecialchars($joueur['taille']); ?>' />
            
            <label class='label-ajouter-joueur' for='poids'>Poids (kg) :</label>
            <input class='input-ajouter-joueur' type='number' name='poids' id='poids' value='<?php echo htmlspecialchars($joueur['poids']); ?>' />
            
            <label class='label-ajouter-joueur' for='statut'>Statut :</label>
            <select class='select-ajouter-joueur' name='statut' id='statut'>
                <option value='actif' <?php echo $joueur['statut'] == 'actif' ? 'selected' : ''; ?>>Actif</option>
                <option value='blesse' <?php echo $joueur['statut'] == 'blesse' ? 'selected' : ''; ?>>Blessé</option>
                <option value='suspendu' <?php echo $joueur['statut'] == 'suspendu' ? 'selected' : ''; ?>>Suspendu</option>
                <option value='absent' <?php echo $joueur['statut'] == 'absent' ? 'selected' : ''; ?>>Absent</option>
            </select>

            
            <div class='actions-ajouter-joueur'>
                <input class='input-ajouter-joueur' type='submit' value='Valider' />
                <a href='page_joueursVue.php'>
                    <input class='input-ajouter-joueur' type='button' value='Annuler' />
                </a>
            </div>
        </form>
    </div>
</body>
</html>
