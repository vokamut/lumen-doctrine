<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    final public function findOneByEmail(string $email): ?object
    {
        return $this->findOneBy(['email' => $email]);
    }
}
