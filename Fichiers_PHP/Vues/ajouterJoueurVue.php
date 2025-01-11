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
    ?>
    <h1>Ajouter un joueur</h1>
        <form action="" method="get">
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
