<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Controllers;

use App\Http\Controllers\CustomerController;
use Tests\TestCases\TestCase;

class CustomerControllerTest extends TestCase
{
    final public function testList(): void
    {
        $customerController = new CustomerController($this->customerRepository);

        $response = $customerController->list();

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $response->getData());
    }

    final public function testShow404Error(): void
    {
        $customerController = new CustomerController($this->customerRepository);

        $response = $customerController->show(PHP_INT_MAX);

        self::assertEquals(404, $response->getStatusCode());
    }
}
