<?php

require_once 'connectionBD.php';
require '../Controleurs/redirectionControleur.php';

class controleurJoueurs{
    
    public function getAllJoueurs(){

        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * FROM joueur');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row){
            $joueur[] = new Joueur(
                $row['nom'],
                $row['prenom'],
                $row['date_de_naissance'],
                $row['taille'],
                $row['poids'],
                $row['num_licence'],
                $row['statut']
            );
        }
        
        return $joueur;
    }

    public function getAllActifs(){

        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * FROM joueur where statut = "Actif"');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row){
            $joueur[] = new Joueur(
                $row['nom'],
                $row['prenom'],
                $row['date_de_naissance'],
                $row['taille'],
                $row['poids'],
                $row['num_licence'],
                $row['statut']
            );
        }
        
        return $joueur;
    }

    public function getJoueur($num_licence){

        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('SELECT * FROM joueur where num_licence = :num_licence');
        $stmt->execute([':num_licence' => $num_licence]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new Joueur(
                $result['nom'],
                $result['prenom'],
                $result['date_de_naissance'],
                $result['taille'],
                $result['poids'],
                $result['num_licence'],
                $result['statut']
            );
        }

        //On retourne null si on a pas de résultat
        return null;
    }

    public function modifierJoueur(Joueur $joueur){

        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('
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
        $db = connectionBD::getInstance()->getConnection();
    
        // Vérification si le num_licence existe déjà dans la base de données
        $stmt = $db->prepare('SELECT COUNT(*) FROM joueur WHERE num_licence = :num_licence');
        $stmt->execute([':num_licence' => $joueur->getNum_licence()]);
        $result = $stmt->fetchColumn();
    
        // Si le num_licence existe déjà, on ne fait pas l'insertion
        if ($result > 0) {
            // Tu peux gérer l'erreur ici, par exemple en lançant une exception ou en retournant un message
            throw new Exception("Le numéro de licence est déjà pris.");
        }
    
        // Préparation de la requête pour l'insertion
        $stmt = $db->prepare('
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
    

    /**
     * Méthode pour supprimer un joueur
     * @param $num_licence 
     */
    public function deleteJoueur($num_licence) {

        // Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();

        // Préparation de la requête
        $stmt = $db->prepare('DELETE FROM joueur WHERE num_licence = :num_licence');

        // On donne une valeur au paramètre
        $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);

        // On exécute la requête
        $stmt->execute();
    }

    public function addCommentaire($num_licence, $description) {

        // Connection a la BDD
        $db = connectionBD::getInstance()->getConnection();
        $today = date("Y-m-d H:i:s");

        // Préparation de la requête
        $stmt = $db->prepare('INSERT INTO commentaire VALUES (:num_licence, :date_commentaire, :description_com)');

        // On donne une valeur au paramètre
        $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
        $stmt->bindParam(':date_commentaire', $today, PDO::PARAM_STR);
        $stmt->bindParam(':description_com', $description, PDO::PARAM_STR);

        // On exécute la requête
        $stmt->execute();
    }

    public function getCommentaires($num_licence) {
        $db = connectionBD::getInstance()->getConnection();
    
        $stmt = $db->prepare('SELECT * FROM commentaire WHERE num_licence = :num_licence');
        $stmt->execute([':num_licence' => $num_licence]);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $commentaires = [];
        
        foreach ($result as $row) {
            $commentaire = new Commentaire($row['description'], $row['date_commentaire']);
            $commentaires[] = $commentaire;
        }
    
        return $commentaires;
    }

    public function aParticipeAMatch($num_licence) {
        $db = connectionBD::getInstance()->getConnection();
    
        // Préparation de la requête
        $stmt = $db->prepare('
            SELECT COUNT(*) AS total 
            FROM participer 
            WHERE num_licence = :num_licence
        ');
    
        $stmt->execute([':num_licence' => $num_licence]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($result && $result['total'] > 0);
    }
    
    
}

?>