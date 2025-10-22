<?php
use MyProject\controllers\PersonController;

return [
    [
        'method' => 'GET',
        'path' => '/persons',
        'handler' => [PersonController::class, 'listAll']
    ],
    [
        'method' => 'GET',
        'path' => '/api/persons/{id}',
        'handler' => [PersonController::class, 'apiListOne']
        //'middleware' => [AuthMiddleware::class]
    ],
    [
        'method' => 'POST',
        'path' => '/api/persons',
        'handler' => [PersonController::class, 'create']
        //'middleware' => [AuthMiddleware::class, ValidationMiddleware::class]
    ],
    [
        'method' => 'GET',
        'path' => '/api/persons/{id}',
        'handler' => [PersonController::class, 'apiListOne']
        //'middleware' => [AuthMiddleware::class]
    ]
];




/* return [
    ['GET', '/persons', PersonController::class . '@listAll'],
    ['GET', 'api/persons/{id}', PersonController::class . '@apiListOne'],
    ['GET', '/api/persons', PersonController::class . '@apiListAll'],
    //['POST', '/api/persons', PersonController::class . '@create'],
    ];
 */

