<?php
declare(strict_types=1);

namespace App\Database\Sources\Customer;

class RandomUserSource implements CustomerSourceInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function firstname(): string
    {
        return (string)$this->data['results']['name']['first'];
    }

    public function lastname(): string
    {
        return (string)$this->data['results']['name']['last'];
    }

    public function email(): string
    {
        return (string)$this->data['results']['email'];
    }

    public function country(): string
    {
        return (string)$this->data['results']['location']['country'];
    }

    public function city(): string
    {
        return (string)$this->data['results']['location']['city'];
    }

    public function username(): string
    {
        return (string)$this->data['results']['login']['username'];
    }

    public function gender(): string
    {
        return (string)$this->data['results']['gender'];
    }

    public function phone(): string
    {
        return (string)$this->data['results']['phone'];
    }
}
