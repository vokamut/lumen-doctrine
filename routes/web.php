<?php

declare(strict_types=1);

use App\Http\Controllers\CustomerController;
use Laravel\Lumen\Routing\Router;

/** @var Laravel\Lumen\Application $app */
$app->router->group(['prefix' => 'customers'], static function (Router $router) {
    $router->get('', CustomerController::class . '@list');
    $router->get('{customerId}', CustomerController::class . '@show');
});
