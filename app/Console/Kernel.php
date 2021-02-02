<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\ImportCustomersFromRandomuserCommand;
use App\Console\Commands\KeyGenerateCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        KeyGenerateCommand::class,
        ImportCustomersFromRandomuserCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    final protected function schedule(Schedule $schedule): void
    {
        //
    }
}
