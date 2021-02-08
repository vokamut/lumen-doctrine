<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class KeyGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    final public function handle(): int
    {
        $path = base_path('.env');

        if (file_exists($path) === false) {
            $this->error($path . ' file not found.');

            return 1;
        }

        file_put_contents(
            $path,
            str_replace(
                'APP_KEY=' . ((string) env('APP_KEY')), 'APP_KEY=' . Str::random(32),
                (string) file_get_contents($path)
            )
        );

        $this->info('Application key set successfully.');

        return 0;
    }
}
