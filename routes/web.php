<?php
declare(strict_types=1);

use App\Http\Controllers\CustomerController;

/** @var Laravel\Lumen\Application $app */
$app->router->get('/customers', CustomerController::class . '@index');
$app->router->get('/customers/{customerId}', CustomerController::class . '@show');
