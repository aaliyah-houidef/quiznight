<?php
require_once 'db_config.php';

class Quiz extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    public function getAllQuizzes() {
        $sql = 'SELECT * FROM quiz';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuizzesByUser($user_id) {
        $sql = 'SELECT * FROM quiz WHERE create_id = :create_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':create_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createQuiz($title, $description, $create_id, $category_id) {
        $sql = 'INSERT INTO quiz (title, description, create_id, category_id) VALUES (:title, :description, :create_id, :category_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_id', $create_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getQuizById($quiz_id) {
        $sql = 'SELECT quiz.*, categories.name AS category_name, categories.icon AS category_icon 
                FROM quiz 
                LEFT JOIN categories ON quiz.category_id = categories.id 
                WHERE quiz.id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
