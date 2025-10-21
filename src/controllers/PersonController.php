<?php
namespace MyProject\controllers;

use MyProject\services\PersonService;

class PersonController {
    private PersonService $service;

    public function __construct() {
        $this->service = new PersonService();
    }

    public function listAll() {                
        //echo (json_encode($this->service->listAllPerson()));
        //include __DIR__ . '/../../public/views/lista.php';
    }

    public function apiListAll() {
        header("Content-Type: application/json");
        echo (json_encode($this->service->listAllPerson()));
    }
}
