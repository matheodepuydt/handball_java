<?php

class controleurJoueurs{
    
    public function getAllJoueurs(){

        $db = Database::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('SELECT * FROM joueur');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getJoueur($num_licence){

        $db = Database::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('SELECT * FROM joueur where num_licence = :num_licence');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function modifierJoueur(Joueur $joueur){

        $db = Database::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('
            UPDATE joueur
            SET nom = :nom, prenom = :prenom, date_de_naissance = :date_de_naissance, 
            taille = :taille, poids = :poids, statut = :statut
            WHERE num_licence = :num_licence
        ');

        $stmt->execute([
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_de_naissance' => $joueur->getDate_de_naissance(),
            ':taille' => $joueur->getTaille(),
            ':poids' => $joueur->getPoids(),
            ':num_licence' => $joueur->getNum_licence(),
            ':statut' => $joueur->getStatut()
        ]);

    }

    public function addJoueur(Joueur $joueur){
        
        $db = Database::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('
            INSERT INTO joueur (num_licence, nom, prenom, date_de_naissance, taille, poids, statut) 
            VALUES (:num_licence, :nom, :prenom, :date_naissance, :taille, :poids, :statut)
        ');

        $stmt->execute([
            ':nom' => $joueur->getNom(),
            ':prenom' => $joueur->getPrenom(),
            ':date_naissance' => $joueur->getDate_de_naissance(),
            ':taille' => $joueur->getTaille(),
            ':poids' => $joueur->getPoids(),
            ':num_licence' => $joueur->getNum_licence(),
            ':statut' => $joueur->getStatut()
        ]);

    }
}

?>