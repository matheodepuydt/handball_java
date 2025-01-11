<?php

require '../classes/joueur.php';

class controleurAjouterJoueur{

    private $server = 'localhost';
    private $bd = 'phphandball';
    private $db_login = 'admin';
    private $db_password = '$iutinfo';
    private $linkpdo;
    
    /**
    * Méthode pour établir la connexion à la base de données
    */
    public function connectionBD() {
        if ($this->linkpdo === null) {
            try {
                $this->linkpdo = new PDO(
                    "mysql:host={$this->server};dbname={$this->bd}", 
                    $this->db_login, 
                    $this->db_password
                );
                $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
    }

    public function addJoueur(Joueur $joueur){
        if (!$this->linkpdo) {
            $this->connectionBD();
        }

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