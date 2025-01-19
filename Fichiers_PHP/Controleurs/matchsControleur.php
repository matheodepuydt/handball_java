<?php
require_once '../classes/rencontre.php';
require_once '../classes/participer.php';
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

    public function getAllParticipationsTitulaires($date_heure) {

        //Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * from participer where date_heure = :date_heure and titulaire = 1');
        $stmt->execute([':date_heure' => $date_heure]);

        // Récupération du résultat de la requête
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On crée un tableau pour stocker les données
        $participer = [];

        // Pour chaque résultat de la requête on crée un Objet Rencontre correspondant qu'on stocke dans le tableau 
        foreach ($result as $row){
            $participer[] = new Participer(
                $row['num_licence'],
                $row['date_heure'],
                $row['titulaire'],
                $row['note'],
                $row['poste']
            );
        }

        // Enfin on retourne le tableau
        return $participer;
    }

    public function getAllParticipationsRemplacants($date_heure) {

        //Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * from participer where date_heure = :date_heure and titulaire = 0');
        $stmt->execute([':date_heure' => $date_heure]);

        // Récupération du résultat de la requête
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On crée un tableau pour stocker les données
        $participer = [];

        // Pour chaque résultat de la requête on crée un Objet Rencontre correspondant qu'on stocke dans le tableau 
        foreach ($result as $row){
            $participer[] = new Participer(
                $row['num_licence'],
                $row['date_heure'],
                $row['titulaire'],
                $row['note'],
                $row['poste']
            );
        }

        // Enfin on retourne le tableau
        return $participer;
    }

    public function updateParticipers($titulaires, $remplacants, $date_heure) {

        // Connection à la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Supprimer les anciens participants pour la date_heure donnée
        $stmt = $db->prepare('
            DELETE FROM participer 
            WHERE date_heure = :date_heure 
            AND num_licence NOT IN (:titulaires, :remplacants)
        ');

        // Construire une liste des num_licence des titulaires et remplaçants
        $num_licence_titulaires = array_map(function($titulaire) {
            return $titulaire->getNum_licence();
        }, $titulaires);

        $num_licence_remplacants = array_map(function($remplacant) {
            return $remplacant->getNum_licence();
        }, $remplacants);

        // Fusionner les deux listes
        $all_licences = array_merge($num_licence_titulaires, $num_licence_remplacants);

        // Convertir les num_licence en une chaîne de valeurs séparées par des virgules
        $num_licence_list = implode(",", $all_licences);

        // Bind de la date_heure et des num_licence
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
        $stmt->bindParam(':titulaires', $num_licence_list, PDO::PARAM_STR);
        $stmt->bindParam(':remplacants', $num_licence_list, PDO::PARAM_STR);

        // Exécuter la suppression
        $stmt->execute();

        // Ajouter ou mettre à jour les titulaires
        foreach ($titulaires as $titulaire) {
            $stmt = $db->prepare('
                INSERT INTO participer (num_licence, date_heure, titulaire, note, poste) 
                VALUES (:num_licence, :date_heure, :titulaire, :note, :poste)
                ON DUPLICATE KEY UPDATE
                    titulaire = VALUES(titulaire),
                    note = VALUES(note),
                    poste = VALUES(poste)
            ');

            $num_licence = $titulaire->getNum_licence();
            $date_heure = $titulaire->getDate();
            $estTitulaire = $titulaire->getTitulaire();
            $note = $titulaire->getNote();
            $poste = $titulaire->getPoste();

            // Bind des paramètres
            $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
            $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
            $stmt->bindParam(':titulaire', $estTitulaire, PDO::PARAM_INT);
            $stmt->bindParam(':note', $note, PDO::PARAM_INT);
            $stmt->bindParam(':poste', $poste, PDO::PARAM_STR);

            // Exécuter la requête
            $stmt->execute();
        }

        // Ajouter ou mettre à jour les remplaçants
        foreach ($remplacants as $remplacant) {
            $stmt = $db->prepare('
                INSERT INTO participer (num_licence, date_heure, titulaire, note, poste) 
                VALUES (:num_licence, :date_heure, :titulaire, :note, :poste)
                ON DUPLICATE KEY UPDATE
                    titulaire = VALUES(titulaire),
                    note = VALUES(note),
                    poste = VALUES(poste)
            ');

            $num_licence = $remplacant->getNum_licence();
            $date_heure = $remplacant->getDate();
            $estTitulaire = $remplacant->getTitulaire();
            $note = $remplacant->getNote();
            $poste = $remplacant->getPoste();

            // Bind des paramètres
            $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
            $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
            $stmt->bindParam(':titulaire', $estTitulaire, PDO::PARAM_INT);
            $stmt->bindParam(':note', $note, PDO::PARAM_INT);
            $stmt->bindParam(':poste', $poste, PDO::PARAM_STR);

            // Exécuter la requête
            $stmt->execute();
        }
    }

    public function getParticipation($date_heure, $num_licence){

        //Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * from participer WHERE date_heure = :date_heure and num_licence = :num_licence');
        $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
        $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
        $stmt->execute();

        // Récupération du résultat de la requête
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // On crée un nouvel Objet Rencontre avec le résulat de la requête et on le renvoie
        if ($result) {
            return new Participer(
                $result['num_licence'],
                $result['date_heure'],
                $result['titulaire'],
                $result['note'],
                $result['poste']
            );
        }

        //On retourne null si on a pas de résultat
        return null;
    }

    

}