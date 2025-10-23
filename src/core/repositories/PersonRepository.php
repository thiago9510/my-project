<?php

namespace App\Core\Repositories;

use MyProject\core\entities\personEntity;
use MyProject\core\database\Database;
use PDO;

class PersonRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function findById(int $id): ?PersonEntity {
        $stmt = $this->db->prepare("SELECT * FROM persons WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        return $data ? new PersonEntity($data) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM persons WHERE deleted_at IS NULL");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new PersonEntity($row), $rows);
    }

    public function insert(PersonEntity $person): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO persons (name, email)
            VALUES (:name, :email)
        ");

        return $stmt->execute([
            'name'  => $person->getName(),
            'email' => $person->getEmail()
        ]);
    }

    public function update(PersonEntity $person): bool
    {
        $stmt = $this->db->prepare("
            UPDATE persons SET name = :name, email = :email, updated_at = CURRENT_TIMESTAMP
            WHERE id = :id AND deleted_at IS NULL
        ");

        return $stmt->execute([
            'id'    => $person->getId(),
            'name'  => $person->getName(),
            'email' => $person->getEmail()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE persons SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }
}
