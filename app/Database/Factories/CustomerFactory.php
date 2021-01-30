<?php
declare(strict_types=1);

namespace App\Database\Factories;

use App\Database\Entities\Customer;
use App\Database\Sources\Customer\CustomerSourceInterface;

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
        return new Customer(
            $this->source->firstname(),
            $this->source->lastname(),
            $this->source->email(),
            $this->source->country(),
            $this->source->username(),
            $this->source->gender(),
            $this->source->city(),
            $this->source->phone(),
        );
    }
}
