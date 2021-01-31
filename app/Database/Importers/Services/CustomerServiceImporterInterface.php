<?php
declare(strict_types=1);

namespace App\Database\Importers\Services;

use App\Database\Sources\Customer\CustomerSourceInterface;

interface CustomerServiceImporterInterface
{
    public function getUsers(int $count): array;

    public function getSource(array $user): CustomerSourceInterface;
}
