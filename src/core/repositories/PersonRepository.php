<?php

namespace MyProject\core\repositories;

use MyProject\core\entities\PersonEntity;
use MyProject\core\database\Database;
use PDO;

class PersonRepository {
    private PDO $db;

    public function __construct(PDO $db) { // Injeção de dependência (melhoria importante)
       // $this->db = Database::connect();
        $this->db = $db;
    }

    // metodo auxiliar  para centralização do mapeamento
    private function mapRows(array $rows): array {
        return array_map(fn($row) => new PersonEntity($row), $rows);
    }

    public function findById(int $id): ?PersonEntity {
        $stmt = $this->db->prepare("SELECT * FROM persons WHERE id = :id AND deleted_at IS NULL");
        //O método prepare() do PDO cria e retorna um objeto da classe PDOStatement;
        //Esse objeto guarda:
        // A SQL original (SELECT * FROM persons WHERE id = :id);
        // As informações sobre os placeholders (:id);
        //Um canal de comunicação entre PHP e o banco, pronto para receber os valores.
        $stmt->execute(['id' => $id]);
        // execute() pertence à classe PDOStatement
        $data = $stmt->fetch();

        return $data ? new PersonEntity($data) : null;
    }

    // Esse comentário garante a tipagem dorreta do findAll quando acessado
    /**
    * @return PersonEntity[]
    */
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM persons WHERE deleted_at IS NULL");
        $rows = $stmt->fetchAll();

       // return array_map(fn($row) => new PersonEntity($row), $rows);
        return $this->mapRows($rows);
    }

    /**
    * @return PersonEntity[]
    */
    public function findPaginated(int $limit = 10, int $offset = 0): array {
        $stmt = $this->db->prepare("
            SELECT * FROM persons
            WHERE deleted_at IS NULL
            ORDER BY id ASC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        //return array_map(fn($row) => new PersonEntity($row), $rows);
        return $this->mapRows($rows);
    }

    public function count(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM persons WHERE deleted_at IS NULL");
        return (int) $stmt->fetch()['total'];
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



    // exemplo de repositório com paginação e filtros

    /**
    * @return PersonEntity[]
    */
    public function findFiltered(array $filters, int $limit = 10, int $offset = 0): array {
        $sql = "SELECT * FROM persons WHERE deleted_at IS NULL";
        $params = [];

        if (!empty($filters['name'])) {
            $sql .= " AND name LIKE :name";
            $params['name'] = '%' . $filters['name'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        $sql .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();

        return $this->mapRows($rows);
    }

    // count para a paginação com filtros
    public function countFiltered(array $filters): int {
        $sql = "SELECT COUNT(*) as total FROM persons WHERE deleted_at IS NULL";
        $params = [];

        if (!empty($filters['name'])) {
            $sql .= " AND name LIKE :name";
            $params['name'] = '%' . $filters['name'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['total'];
    }



    //paginação com cursos (modo avançado)

    /**
    * @return PersonEntity[]
    */
    public function findFilteredCursor(array $filters, ?int $lastId = null, int $limit = 10): array {
        $sql = "SELECT * FROM persons WHERE deleted_at IS NULL";

        if (!empty($filters['name'])) {
            $sql .= " AND name LIKE :name";
        }

        if ($lastId !== null) {
            $sql .= " AND id > :lastId";
        }

        $sql .= " ORDER BY id ASC LIMIT :limit";

        $stmt = $this->db->prepare($sql);

        if (!empty($filters['name'])) {
            $stmt->bindValue('name', '%' . $filters['name'] . '%');
        }

        if ($lastId !== null) {
            $stmt->bindValue('lastId', $lastId, PDO::PARAM_INT);
        }

        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $this->mapRows($rows);
    }

    // total com filtros para o cursos
    public function countFilteredCursos(array $filters = []): int {
    $sql = "SELECT COUNT(*) as total FROM persons WHERE deleted_at IS NULL";
    $params = [];

    if (!empty($filters['name'])) {
        $sql .= " AND name LIKE :name";
        $params['name'] = '%' . $filters['name'] . '%';
    }

    if (!empty($filters['status'])) {
        $sql .= " AND status = :status";
        $params['status'] = $filters['status'];
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return (int) $stmt->fetch()['total'];
    }




}
