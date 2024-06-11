<?php

require_once 'bdd.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        try {
            $stmt = $this->conn->query('SELECT * FROM users');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error recovering users : " . $e->getMessage();
            return [];
        }
    }

    public function addUser($username, $email, $password) {
        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            echo "New user added successful !";
        } catch (PDOException $e) {
            echo "Error add user : " . $e->getMessage();
        }
    }

    public function authenticate($email, $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error during authentication : " . $e->getMessage();
            return null;
        }
    }
}

?>
