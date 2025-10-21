<?php
use MyProject\controllers\PersonController;

return [
    ['GET', '/persons', PersonController::class . '@listAll'],
    ['GET', '/api/persons', PersonController::class . '@apiListAll'],
    //['POST', '/api/persons', PersonController::class . '@create'],
];
