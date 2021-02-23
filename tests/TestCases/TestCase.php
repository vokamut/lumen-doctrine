<?php

declare(strict_types=1);

namespace Tests\TestCases;

use App\Database\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Console\Kernel;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * Creates the application.
     *
     * @return Application
     */
    final public function createApplication(): Application
    {
        return require __DIR__ . '/../../bootstrap/app.php';
    }

    /**
     * Create database using doctrine command.
     *
     * @return void
     */
    final public function setUp(): void
    {
        parent::setUp();

        $this->app->make(Kernel::class)->call('doctrine:schema:create');

        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        $this->customerRepository = $this->app->make(CustomerRepository::class);
    }

    /**
     * Drop database using doctrine command.
     *
     * @return void
     */
    final public function tearDown(): void
    {
        $this->app->make(Kernel::class)->call('doctrine:schema:drop', ['--force' => true]);

        parent::tearDown();
    }
}
