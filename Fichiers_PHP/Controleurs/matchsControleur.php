<?php
require_once '../classes/rencontre.php';
require_once 'connectionBD.php';
require '../Controleurs/redirectionControleur.php';

class matchsControleur {

    /**
     * Méthode pour récupérer tout les matchs en base de donnée
     * @return Rencontre[] tableau de tout les objets en BDD
     */
    public function getAllMatchs() {

        //Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * from Rencontre');
        $stmt->execute();

        // Récupération du résultat de la requête
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On crée un tableau pour stocker les données
        $matchs = [];

        // Pour chaque résultat de la requête on crée un Objet Rencontre correspondant qu'on stocke dans le tableau 
        foreach ($result as $row){
            $matchs[] = new Rencontre(
                $row['date_heure'],
                $row['nom_adversaire'],
                $row['lieu'],
                $row['domicile'],
                $row['resultat']
            );
        }

        // Enfin on retourne le tableau
        return $matchs;
    }

    /**
     * Méthode qui récupère un match selon son identifiant (date_heure)
     * @param string $date_heure
     * @return Rencontre 
     */
    public function getMatch($date_heure){

        //Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * from Rencontre WHERE date_heure = :date_heure ');
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
        $stmt->execute();

        // Récupération du résultat de la requête
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // On crée un nouvel Objet Rencontre avec le résulat de la requête et on le renvoie
        if ($result) {
            return new Rencontre(
                $result['date_heure'],
                $result['nom_adversaire'],
                $result['lieu'],
                $result['domicile'],
                $result['resultat']
            );
        }

        //On retourne null si on a pas de résultat
        return null;
    }

    /**
     * Méthode pour ajouter un objet Rencontre en BDD
     * @param Rencontre $rencontre
     */
    public function addMatch (Rencontre $rencontre) {

        // Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Vérification si le num_licence existe déjà dans la base de données
        $stmt = $db->prepare('SELECT COUNT(*) FROM rencontre WHERE date_heure = :date_heure');
        $stmt->execute([':date_heure' => $rencontre->getDate()]);
        $result = $stmt->fetchColumn();
    
        // Si le num_licence existe déjà, on ne fait pas l'insertion
        if ($result > 0) {
            // Tu peux gérer l'erreur ici, par exemple en lançant une exception ou en retournant un message
            throw new Exception("Il y a déjà un match a cette date et a cette heure");
        }

        // Préparation de la requête
        $stmt = $db->prepare('INSERT  INTO Rencontre (date_heure, nom_adversaire, lieu, domicile, resultat)
        VALUES (:date_heure, :nom_adversaire,:lieu,:domicile,:resultat)');

        $date_heure = $rencontre->getDate();
        $nom_adversaire = $rencontre->getAdversaire();
        $lieu = $rencontre->getLieu();
        $domicile = $rencontre->getDomicile();
        $resultat = $rencontre->getResultat();

        // On donne une valeur aux paramètres
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
        $stmt->bindParam(':nom_adversaire', $nom_adversaire, PDO::PARAM_STR);
        $stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
        $stmt->bindParam(':domicile', $domicile, PDO::PARAM_STR);
        $stmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);

        // On exécute la requête
        $stmt->execute();
    }

    /**
     * Méthode pour modifier un match en BDD avec un objet Rencontre
     * @param Rencontre $rencontre
     */
    public function modifierMatch(Rencontre $rencontre){

        // Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('UPDATE Rencontre SET nom_adversaire = :nom_adversaire, lieu = :lieu,
            domicile = :domicile, resultat = :resultat
            WHERE date_heure = :date_heure');

        $date_heure = $rencontre->getDate();
        $nom_adversaire = $rencontre->getAdversaire();
        $lieu = $rencontre->getLieu();
        $domicile = $rencontre->getDomicile();
        $resultat = $rencontre->getResultat();

        // On donne une valeur aux paramètres
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
        $stmt->bindParam(':nom_adversaire', $nom_adversaire, PDO::PARAM_STR);
        $stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
        $stmt->bindParam(':domicile', $domicile, PDO::PARAM_STR);
        $stmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);

        // On exécute la requête
        $stmt->execute();

    }

    /**
     * Méthode pour supprimer une rencontre 
     * @param $date_heure
     */
    public function deleteMatch($date_heure) {

        // Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('DELETE FROM Rencontre WHERE date_heure = :date_heure');

        // On donne une valeur au paramètre
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);

        // On exécute la requête
        $stmt->execute();
    }

    public function getNotes($num_licence) {
        $db = connectionBD::getInstance()->getConnection();
    
        $stmt = $db->prepare('SELECT p.note, r.date_heure, r.nom_adversaire
                            FROM participer p, rencontre r
                            WHERE p.num_licence = :num_licence
                            AND p.date_heure = r.date_heure;
                            ');
        $stmt->execute([':num_licence' => $num_licence]);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }

}