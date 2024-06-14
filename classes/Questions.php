<?php
require_once 'db_config.php';
require_once 'Answers.php';

class Questions extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    public function getQuestionsByQuiz($quiz_id) {
        $sql = 'SELECT * FROM questions WHERE quiz_id = :quiz_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addQuestion($quiz_id, $question_text) {
        $sql = 'INSERT INTO questions (quiz_id, question) VALUES (:quiz_id, :question)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->bindParam(':question', $question_text);
        return $stmt->execute();
    }

    public function deleteQuestion($question_id) {
        $answersClass = new Answers();
        $answersClass->deleteAnswersByQuestion($question_id);

        $sql = 'DELETE FROM questions WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $question_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
