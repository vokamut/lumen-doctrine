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
    protected CustomerSourceInterface $source;

    public function __construct(CustomerSourceInterface $source)
    {
        $this->source = $source;
    }

    public function create(): Customer
    {
        return new Customer(
            $this->source->firstname(),
            $this->source->lastname(),
            $this->source->email(),
            $this->source->country(),
            $this->source->city(),
            $this->source->username(),
            $this->source->gender(),
            $this->source->phone(),
        );
    }
}
