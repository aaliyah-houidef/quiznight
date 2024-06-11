<?php
require_once 'db_config.php';

class Quiz extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    // Méthode 1: récupérer tous les quiz
    public function getAllQuizzes() {
        $sql = 'SELECT * FROM quiz';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode 2: récupérer les quiz d'un utilisateur spécifique
    public function getQuizzesByUser($user_id) {
        $sql = 'SELECT * FROM quiz WHERE create_id = :create_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':create_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode 3: créer un nouveau quiz
    public function createQuiz($title, $description, $create_id) {
        $sql = 'INSERT INTO quiz (title, description, create_id) VALUES (:title, :description, :create_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_id', $create_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
