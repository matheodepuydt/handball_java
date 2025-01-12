<?php
class connectionBD {
    private static $instance = null;
    private $connection;

    private $server = 'localhost';
    private $bd = 'phphandball';
    private $db_login = 'admin';
    private $db_password = '$iutinfo';

    /**
     * Constructeur privé pour empêcher l'instanciation directe
     */
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->server};dbname={$this->bd}",
                $this->db_login,
                $this->db_password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    /**
     * Méthode pour récupérer l'instance unique de la classe
     * @return connectionBD
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new connectionBD();
        }
        return self::$instance;
    }

    
    /**
     * Méthode pour récupérer la connection
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Empêche le clonage de l'objet
     */
    private function __clone() {}
}
?>