<?php

declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Entities\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    final public function findOneByEmail(string $email): ?object
    {
        return $this->findOneBy(['email' => $email]);
    }

    final public function findAllForList(): array
    {
        return array_map(static function (Customer $customer) {
            return $customer->toArrayForList();
        }, $this->findAll());
    }
}
