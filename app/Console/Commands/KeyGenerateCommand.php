<?php

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
    protected $description = "Set the application key";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents(
                $path,
                str_replace('APP_KEY=' . env('APP_KEY'), 'APP_KEY=' . Str::random(32), file_get_contents($path))
            );
        }

        $this->info("Application key set successfully.");
    }
}
