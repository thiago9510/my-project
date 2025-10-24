<?php

require_once __DIR__ . '../../../vendor/autoload.php';
// se estiver usando autoload
use MyProject\core\database\Database;
use MyProject\core\repositories\PersonRepository;

$pdo = Database::connect();
$repo = new PersonRepository($pdo);

// Testar busca por ID
/* $pessoa = $repo->findById(1);
if ($pessoa) {
    echo "Nome: " . $pessoa->getName() . PHP_EOL;
} else {
    echo "Pessoa não encontrada." . PHP_EOL;
} */

// Testar listagem
//$pessoas = $repo->findAll();
//var_dump($pessoas[0]);
//print_r($pessoas[0]->getName());
//print_r($pessoas[0]);

/* foreach ($pessoas as $p) {
    echo $p;
   //echo $p->getId() . " - " . $p->getName() . PHP_EOL;
} */


// php test_person_repo.php


/* Exibe todos os métodos disponíveis de um objeto (os públicos, protegidos, privados etc.
print_r(get_class_methods($pessoas[0])); */


$filter = ['name' => 'thiago'];
$lastId = 1;

$result = $repo->findFilteredCursor($filter,$lastId,1);
print_r($result);