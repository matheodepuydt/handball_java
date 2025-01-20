<?php

require_once 'connectionBD.php';
require '../Controleurs/redirectionControleur.php';

class controleurStat{

    public function getNbVictoires(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Victoire"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getNbDefaites(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Defaite"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getNbNuls(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Match Nul"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }
    
    public function getAllJoueurs(){

        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT num_licence, nom, prenom, statut FROM joueur');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getNbTitularisations($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total FROM participer where num_licence = :num_licence and titulaire = 1');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getNbRemplacements($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total FROM participer where num_licence = :num_licence and titulaire = 0');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getMoyenneNote($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT avg(note) as total FROM participer where num_licence = :num_licence and note != 0');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getNbVictoiresJoueur($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total 
                            from rencontre 
                            where resultat = "Victoire" 
                            and date_heure in (
                                select date_heure
                                from participer
                                where num_licence = :num_licence)');
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function getNbMatchsJoueur($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total
                            from rencontre 
                            where date_heure in (
                                select date_heure
                                from participer
                                where num_licence = :num_licence)');
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    public function calculPourcentageVictoiresJoueur($num_licence){
        $controleur = new controleurStat();
        $nbVictoires = $controleur->getNbVictoiresJoueur($num_licence);
        $nbTotal = $controleur->getNbMatchsJoueur($num_licence)+$controleur->getNbVictoiresJoueur($num_licence);
        $pourcentageVictoires = ($nbTotal > 0) ? ($nbVictoires / $nbTotal) * 100 : 0;
        return $pourcentageVictoires;
    }

    public function getPostePrefereJoueur($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT poste, COUNT(*) AS nombre_de_participations
                            FROM participer
                            WHERE num_licence = :num_licence
                            GROUP BY poste
                            ORDER BY nombre_de_participations DESC
                            LIMIT 1');
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['poste'];
        } else {
            return null; // Aucun poste trouvé
        }
    }

    public function getNbMatchsConsecutifs($num_licence) {
        $db = connectionBD::getInstance()->getConnection();
    
        // Préparation de la requête
        $stmt = $db->prepare('WITH matchs_joues AS (
                SELECT date_heure
                FROM participer
                WHERE num_licence = :num_licence
            ),
            derniere_absence AS (
                SELECT MAX(date_heure) AS derniere_absence
                FROM rencontre
                WHERE date_heure NOT IN (SELECT date_heure FROM matchs_joues)
                AND date_heure < NOW()
            )
            SELECT COUNT(*) AS nb_matchs_consecutifs
            FROM matchs_joues
            WHERE date_heure > (SELECT derniere_absence FROM derniere_absence) 
            AND date_heure < NOW();
        ');
    
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['nb_matchs_consecutifs'] : 0;
    }
    

}

?>