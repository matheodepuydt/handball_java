<?php
    require '../classes/joueur.php';
    require '../Controleurs/joueursControleur.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <title>Ajouter joueur</title>
</head>
<body>
    <?php
    include('../static/header.html');
    session_start();
    

    // Initialisation des variables pour éviter des erreurs si le formulaire n'est pas soumis
    $nom = $prenom = $date_de_naissance = $taille = $poids = $num_licence = $statut = "";
    $error_message = "";

    // Traitement du formulaire si une soumission a été effectuée
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Récupération des données du formulaire en toute sécurité
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date_de_naissance = htmlspecialchars($_POST['date_de_naissance']);
        $taille = htmlspecialchars($_POST['taille']);
        $poids = htmlspecialchars($_POST['poids']);
        $num_licence = htmlspecialchars($_POST['num_licence']);
        $statut = htmlspecialchars($_POST['statut']);

        $joueur = new Joueur($nom,$prenom,$date_de_naissance,$taille,$poids,$num_licence,$statut);
        $controleur = new controleurJoueurs();

        try {
            // Appel de la méthode pour ajouter le joueur
            $controleur->addJoueur($joueur);
            header("Location: page_joueursVue.php");
        exit(); // Important pour arrêter l'exécution après la redirection
        } catch (Exception $e) {
            // Gestion de l'exception si le num_licence est déjà pris
            $error_message = "Attention : " . $e->getMessage(); // Affiche le message d'erreur
        }
    }
    ?>
    <div class="form-ajouter-joueur-container">
    <h1>Ajouter un joueur</h1>
    <?php if (!empty($error_message)) : ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <label class="label-ajouter-joueur" for="nom">Nom :</label>
        <input class="input-ajouter-joueur" type="text" name="nom" id="nom" required />

        <label class="label-ajouter-joueur" for="prenom">Prénom :</label>
        <input class="input-ajouter-joueur" type="text" name="prenom" id="prenom" required />

        <label class="label-ajouter-joueur" for="date_de_naissance">Date de naissance :</label>
        <input class="input-ajouter-joueur" type="date" name="date_de_naissance" id="date_de_naissance" />

        <label class="label-ajouter-joueur" for="taille">Taille (cm) :</label>
        <input class="input-ajouter-joueur" type="number" name="taille" id="taille" />

        <label class="label-ajouter-joueur" for="poids">Poids (kg) :</label>
        <input class="input-ajouter-joueur" type="number" name="poids" id="poids" />

        <label class="label-ajouter-joueur" for="num_licence">Numéro de licence :</label>
        <input class="input-ajouter-joueur" type="text" name="num_licence" id="num_licence" required />

        <label class="label-ajouter-joueur" for="statut">Statut :</label>
        <select class="select-ajouter-joueur" name="statut" id="statut">
            <option value="actif">Actif</option>
            <option value="blesse">Blessé</option>
            <option value="suspendu">Suspendu</option>
            <option value="absent">Absent</option>
        </select>

        <div class="actions-ajouter-joueur">
            <input class="input-ajouter-joueur" type="submit" value="Valider" />
            <a href="page_joueursVue.php">
                <input class="input-ajouter-joueur" type="button" value="Annuler" />
            </a>
        </div>
    </form>
</div>

</body>
</html>
