<?php

require_once 'connectionBD.php';

class controleurStat{

    public function getNbVictoires(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Victoire"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getNbDefaites(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Defaite"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getNbNuls(){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Match Nul"');
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
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
        
        return $result;
    }

    public function getNbRemplacements($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total FROM participer where num_licence = :num_licence and titulaire = 0');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getMoyenneNote($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT avg(note) as total FROM participer where num_licence = :num_licence');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getNbVictoiresJoueur($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Victoire"');
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getNbMatchsJoueur($num_licence){
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT count(*) as total from rencontre where resultat = "Victoire"');
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

}

?>