<?php
require_once 'db_config.php';

class Users extends Bdd {
    public $user_id;
    public $username;

    public function __construct() {
        parent::__construct();
    }

    // Méthode 1 : pour ajouter un utilisateur à la base de données
    public function addUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (username, password) VALUES (:username, :password)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // Méthode 2: vérifier le mot de passe de l'utilisateur
    public function verifyPassword($username, $password) {
        $sql = 'SELECT user_id, password FROM users WHERE username = :username';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['user_id'];
        }
        return false;
    }

    // Méthode pour récupérer les informations d'un utilisateur par ID
    public function getUserById($user_id) {
        $sql = 'SELECT user_id, username FROM users WHERE user_id = :user_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
