<?php

class controleurJoueurs{
    
    
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
    
    public function getAllJoueurs(){

        if (!$this->linkpdo) {
            $this->connectionBD();
        }

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('SELECT * FROM joueur');
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
}

?>