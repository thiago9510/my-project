<?php

//require_once 'vendor/autoload.php'; // se estiver usando autoload
use MyProject\core\database\Database;
use App\Core\Repositories\PersonRepository;

$repo = new PersonRepository();

// Testar busca por ID
$pessoa = $repo->findById(1);
if ($pessoa) {
    echo "Nome: " . $pessoa->getName() . PHP_EOL;
} else {
    echo "Pessoa não encontrada." . PHP_EOL;
}

// Testar listagem
$pessoas = $repo->findAll();
foreach ($pessoas as $p) {
    echo $p->getId() . " - " . $p->getName() . PHP_EOL;
}


// php test_person_repo.php
