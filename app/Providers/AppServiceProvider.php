<?php

declare(strict_types=1);

namespace App\Providers;

use App\Database\Entities\Customer;
use App\Database\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    final public function register(): void
    {
        $this->app->bind(CustomerRepository::class, function (Application $app) {
            /** @var EntityManagerInterface $entityManager */
            $entityManager = $app['em'];

            return new CustomerRepository(
                $entityManager,
                $entityManager->getClassMetaData(Customer::class)
            );
        });
    }
}
