<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Database\Importers\CustomerImporter;
use App\Database\Importers\Services\RandomUserService;

class ImportOneCustomerJob extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    final public function handle(): void
    {
        (new CustomerImporter(new RandomUserService()))->import(1);
    }
}
