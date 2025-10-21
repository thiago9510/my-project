<?php
require __DIR__ . '/../vendor/autoload.php';

use MyProject\core\Database;

try {
    $pdo = Database::connect();

    // Teste: inserir uma pessoa
    $stmt = $pdo->prepare("INSERT INTO persons (name, email) VALUES (:name, :email)");
    $stmt->execute([
        'name' => 'Thiago Dev',
        'email' => 'thiago@example.com'
    ]);

    // Teste: buscar todas as pessoas
    $result = $pdo->query("SELECT * FROM persons WHERE deleted_at IS NULL")->fetchAll();

    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
