<?php
class Bdd {
    protected $conn;

    public function __construct() {
        try {
            // Connexion à la base de données
            $this->conn = new PDO('mysql:host=localhost;dbname=quiz-night;charset=utf8', 'root', '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>

