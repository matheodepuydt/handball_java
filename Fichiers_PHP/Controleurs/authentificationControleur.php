<?php
class authentificationControleur{

    /**
     * Méthode pour récupérer le mot de passe associé à un login
     * @param string $login
     * @param string $password
     * @return bool
     */

    public function verifyPasswordByLogin($login, $password){

        $db = connectionBD::getInstance()->getConnection();

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