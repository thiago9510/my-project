<?php
namespace MyProject\core\database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $host = '127.0.0.1';
                $dbname = 'my_project';
                $user = 'root';
                $pass = '123';

                $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

                self::$connection = new PDO($dsn, $user, $pass);

                // 🔸 Configurações recomendadas
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (PDOException $e) {
                // Se algo der errado, lança um erro mais descritivo
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
