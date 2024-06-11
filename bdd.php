<?php

class Database {
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=quiz-night;charset=utf8', 'root', 'root');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie à la base de données quiz-night !";
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            die();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>