<?php

declare(strict_types=1);

namespace App\Database\Factories;

use App\Database\Entities\Customer;
use App\Database\Repositories\CustomerRepository;
use App\Database\Sources\Customer\CustomerSourceInterface;
use LaravelDoctrine\ORM\Facades\EntityManager;

class CustomerFactory
{
    /**
     * @var CustomerSourceInterface
     */
    private CustomerSourceInterface $source;

    /**
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    public function __construct(CustomerSourceInterface $source)
    {
        /** @var CustomerRepository $customerRepository */
        $this->customerRepository = app(CustomerRepository::class);
        $this->source = $source;
    }

    final public function create(): Customer
    {
        $customer = new Customer(
            $this->source->firstname(),
            $this->source->lastname(),
            $this->source->email(),
            $this->source->country(),
            $this->source->username(),
            $this->source->gender(),
            $this->source->city(),
            $this->source->phone(),
        );

        EntityManager::persist($customer);
        EntityManager::flush();

        return $customer;
    }

    final public function update(int $id): ?Customer
    {
        $customer = $this->customerRepository->find($id);

        if (($customer instanceof Customer) === false) {
            return null;
        }

        EntityManager::persist($customer);
        EntityManager::flush();

        return $customer;
    }
}
