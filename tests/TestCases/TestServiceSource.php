<?php

namespace Tests\TestCases;

use App\Database\Sources\Customer\CustomerSourceInterface;

class TestServiceSource implements CustomerSourceInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    final public function firstname(): string
    {
        return (string)$this->data['firstname'];
    }

    final public function lastname(): string
    {
        return (string)$this->data['lastname'];
    }

    final public function email(): string
    {
        return (string)$this->data['email'];
    }

    final public function country(): string
    {
        return (string)$this->data['country'];
    }

    final public function city(): string
    {
        return (string)$this->data['city'];
    }

    final public function username(): string
    {
        return (string)$this->data['username'];
    }

    final public function gender(): bool
    {
        return (bool)$this->data['gender'];
    }

    final public function phone(): string
    {
        return (string)$this->data['phone'];
    }
}
