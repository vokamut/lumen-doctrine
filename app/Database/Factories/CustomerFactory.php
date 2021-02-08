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

    public function __construct(CustomerSourceInterface $source)
    {
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
        /** @var CustomerRepository $customerRepository */
        $customerRepository = app(CustomerRepository::class);

        $customer = $customerRepository->find($id);

        if (($customer instanceof Customer) === false) {
            return null;
        }

        $customer->setFirstname($this->source->firstname());
        $customer->setLastname($this->source->lastname());
        $customer->setEmail($this->source->email());
        $customer->setCountry($this->source->country());
        $customer->setUsername($this->source->username());
        $customer->setGender($this->source->gender());
        $customer->setCity($this->source->city());
        $customer->setPhone($this->source->phone());

        EntityManager::persist($customer);
        EntityManager::flush();

        return $customer;
    }
}
