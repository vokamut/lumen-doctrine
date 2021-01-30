<?php
declare(strict_types=1);

namespace App\Database\Sources\Customer;

class RandomUserSource implements CustomerSourceInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    final public function firstname(): string
    {
        return (string)$this->data['results']['name']['first'];
    }

    final public function lastname(): string
    {
        return (string)$this->data['results']['name']['last'];
    }

    final public function email(): string
    {
        return (string)$this->data['results']['email'];
    }

    final public function country(): string
    {
        return (string)$this->data['results']['location']['country'];
    }

    final public function city(): string
    {
        return (string)$this->data['results']['location']['city'];
    }

    final public function username(): string
    {
        return (string)$this->data['results']['login']['username'];
    }

    final public function gender(): bool
    {
        return (bool)$this->data['results']['gender'];
    }

    final public function phone(): string
    {
        return (string)$this->data['results']['phone'];
    }
}
