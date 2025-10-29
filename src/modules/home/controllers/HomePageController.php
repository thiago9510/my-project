<?php
namespace MyProject\modules\home\controllers;

class HomePageController {
    public function index(): void {
        $title = 'Home';
        $content = __DIR__ . '/../views/home-content.php';
        include __DIR__ . '/../../layout/layout.php';
    }
}

/* Aqui você está dizendo: "Quero usar o layout padrão e injetar o conteúdo da home dentro dele." */