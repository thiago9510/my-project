<?php
namespace MyProject\core\database;

use PDO;
use PDOException;

class Database {
    public static function connect(): PDO {
        try {
            $dsn = "mysql:host=127.0.0.1;dbname=my_project;charset=utf8mb4";
            return new PDO($dsn, "root", "123", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao conectar ao banco: " . $e->getMessage()]);
            exit;
        }
    }
}
