<?php

declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Entities\Customer;

interface CustomerRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return Customer|null
     */
    public function findOneByEmail(string $email): ?object;

    /**
     * @return Customer[]
     *
     * @psalm-return list<array>
     */
    public function findAllForList(): array;
}
