<?php
class authentificationControleur{

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

    /**
     * Méthode pour récupérer le mot de passe associé à un login
     * @param string $login
     * @param string $password
     * @return bool
     */

    public function verifyPasswordByLogin($login, $password){
        if (!$this->linkpdo) {
            $this->connectionBD();
        }

        // Préparation de la requête
        $stmt = $this->linkpdo->prepare('SELECT password FROM authentification WHERE login = :login');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe (supposant qu'il est hashé en BDD)
        if ($result) {
            return password_verify($password, $result['password']);
        }

        return false;
    }
}

?>