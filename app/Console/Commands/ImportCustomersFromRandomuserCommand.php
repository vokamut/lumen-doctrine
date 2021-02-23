<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Database\Importers\CustomerImporter;
use App\Database\Importers\Services\RandomUserService;
use Illuminate\Console\Command;

class ImportCustomersFromRandomuserCommand extends Command
{
    private const COUNT = 100;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:customers:from:randomuser';

    /**
     * The console command description.
     *
     * @var null|string
     */
    protected $description = 'Import customers from randomuser.me service.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    final public function handle(): int
    {
        $randomUsersResult = (new CustomerImporter(new RandomUserService()))->import(self::COUNT);

        if ($randomUsersResult === false) {
            $this->error('Something went wrong. Show log file.');

            return 1;
        }

        $this->info(self::COUNT . ' customers imported successfully');

        return 0;
    }
}
