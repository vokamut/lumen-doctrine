<?php
declare(strict_types=1);

namespace App\Providers;

use App\Database\Entities\Customer;
use App\Database\Repositories\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    final public function register(): void
    {
        $this->app->bind(CustomerRepository::class, function($app) {
            return new CustomerRepository(
                $app['em'],
                $app['em']->getClassMetaData(Customer::class)
            );
        });
    }
}
