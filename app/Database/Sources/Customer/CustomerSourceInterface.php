<?php

declare(strict_types=1);

namespace App\Database\Sources\Customer;

interface CustomerSourceInterface
{
    /**
     * @return string
     */
    public function firstname(): string;

    /**
     * @return string
     */
    public function lastname(): string;

    /**
     * @return string
     */
    public function email(): string;

    /**
     * @return string
     */
    public function country(): string;

    /**
     * @return string
     */
    public function city(): string;

    /**
     * @return string
     */
    public function username(): string;

    /**
     * @return bool
     */
    public function gender(): bool;

    /**
     * @return string
     */
    public function phone(): string;
}
