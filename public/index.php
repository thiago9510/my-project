<?php
require __DIR__ . '/../vendor/autoload.php';

use  MyProject\routes\Router;
//error_log("DEBUGAR"); // pode ser usado para debugar no terminal

$routes = require __DIR__ . '/../src/routes/web.php';
$router = new Router($routes);
$router->handle($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
