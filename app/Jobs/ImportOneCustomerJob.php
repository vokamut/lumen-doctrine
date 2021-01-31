<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Importers\RandomUserImporter;

class ImportOneCustomerJob extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    final public function handle(): void
    {
        (new RandomUserImporter)->importUsers(1);
    }
}
