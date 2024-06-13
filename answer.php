<?php

require_once 'bdd.php';


class Answer {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAnswersByQuestion($question_id) {
        try {
            $sql = "SELECT * FROM answers WHERE question_id = :question_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':question_id' => $question_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des réponses : " . $e->getMessage();
            return [];
        }
    }

    public function addAnswer($question_id, $answer_text) {
        try {
            $sql = "INSERT INTO answers (question_id, answer_text) VALUES (:question_id, :answer_text)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':question_id' => $question_id,
                ':answer_text' => $answer_text,
            ]);
            echo "Nouvelle réponse ajoutée avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
        }
    }

    public function updateAnswer($id, $answer_text) {
        try {
            $sql = "UPDATE answers SET answer_text = :answer_text  WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':answer_text' => $answer_text,
                ':id' => $id
            ]);
            echo "Réponse mise à jour avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la réponse : " . $e->getMessage();
        }
    }

    public function deleteAnswer($id) {
        try {
            $sql = "DELETE FROM answers WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            echo "Réponse supprimée avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la réponse : " . $e->getMessage();
        }
    }
}

?>
