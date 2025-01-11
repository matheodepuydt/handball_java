<?php
    //require '../classes/joueur.php';
    require '../Controleurs/ajouterJoueurControleur.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter joueur</title>
</head>
<body>
    <?php
    include('../static/header.html');  
    session_start();
    

    // Initialisation des variables pour éviter des erreurs si le formulaire n'est pas soumis
    $nom = $prenom = $date_de_naissance = $taille = $poids = $num_licence = $statut = "";

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
        $controleur = new controleurAjouterJoueur();

        $controleur->addJoueur($joueur);
        header("Location: page_joueursVue.php");
        exit(); // Important pour arrêter l'exécution après la redirection
    }
    ?>
    <h1>Ajouter un joueur</h1>
        <form action="" method="post">
            <div>
                <label for="name">Nom :</label>
                <input type="text" name="nom" id="nom" required />
            </div>
            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" required />
            </div>
            <div>
                <label for="date_de_naissance">Date de naissance :</label>
                <input type="date" name="date_de_naissance" id="date_de_naissance">
            </div>
            <div>
                <label for="taille">Taille :</label>
                <input type="number" name="taille" id="taille"> cm
            </div>
            <div>
                <label for="poids">Poids :</label>
                <input type="number" name="poids" id="poids"> kg
            </div>
            <div>
                <label for="num_licence">Numéro de licence :</label>
                <input type="text" name="num_licence" id="num_licence" required />
            </div>
            <label for="statut">Statut :</label>
                <select name="statut" id="statut">
                    <option value="actif">Actif</option>
                    <option value="blesse">Blessé</option>
                    <option value="suspendu">Suspendu</option>
                    <option value="absent">Absent</option>
                </select>
            <div>
                <input type="submit" value="Valider" />
                <a href="page_joueursVue.php">
                    <input type="button" value="Annuler" />
                </a>

            </div>
        </form>
</body>
</html>
