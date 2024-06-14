<?php
require_once 'db_config.php';

class Categories extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    public function createCategory($name, $icon) {
        $sql = 'INSERT INTO categories (name, icon) VALUES (:name, :icon)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':icon', $icon);
        return $stmt->execute();
    }

    public function getAllCategories() {
        $sql = 'SELECT * FROM categories';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
