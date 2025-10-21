<?php
namespace MyProject\models;

use MyProject\core\Database;

class PersonModel {
    public function getAll(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM persons");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO pessoas (nome) VALUES (:nome)");
        return $stmt->execute(['nome' => $data['nome']]);
    }
}
