<?php
use MyProject\modules\persons\controllers\PersonPageController;
use MyProject\modules\persons\controllers\PersonApiController;
use MyProject\modules\home\controllers\HomePageController;
return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => [HomePageController::class, 'index']
    ],

    [
        'method' => 'GET',
        'path' => '/persons',
        'handler' => [PersonPageController::class, 'index']
    ],

    // exemple
    [
        'method' => 'GET',
        'path' => '/api/persons/{id}',
        'handler' => [PersonApiController::class, 'apiListOne']
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

