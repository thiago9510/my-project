<?php
namespace MyProject\modules\persons\controllers;

class PersonPageController {
    public function index(): void {
        $title = 'Persons';
        $content = __DIR__ .'/../views/persons-content.php';
        include __DIR__ . '/../../layout/layout.php';
    }
}