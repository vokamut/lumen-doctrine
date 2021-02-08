<?php

declare(strict_types=1);

namespace App\Database\Importers;

use App\Database\Entities\Customer;
use App\Database\Factories\CustomerFactory;
use App\Database\Importers\Services\CustomerServiceImporterInterface;
use App\Database\Repositories\CustomerRepository;
use RuntimeException;

class CustomerImporter
{
    /**
     * @var CustomerServiceImporterInterface
     */
    private CustomerServiceImporterInterface $serviceImporter;

    public function __construct(CustomerServiceImporterInterface $serviceImporter)
    {
        $this->serviceImporter = $serviceImporter;
    }

    final public function import(int $count): bool
    {
        if ($count < 1) {
            throw new RuntimeException('Count must be greater than 0');
        }

        /** @var array[] $users */
        $users = $this->serviceImporter->getUsers($count);

        if (count($users) === 0) {
            return false;
        }

        /** @var CustomerRepository $customerRepository */
        $customerRepository = app(CustomerRepository::class);

        foreach ($users as $user) {
            /** @var Customer|null $customer */
            $customer = $customerRepository->findOneByEmail((string) $user['email']);

            if ($customer === null) {
                (new CustomerFactory(
                    $this->serviceImporter->getSource($user)
                ))->create();
            } else {
                (new CustomerFactory(
                    $this->serviceImporter->getSource($user)
                ))->update($customer->getId());
            }
        }

        return true;
    }
}
