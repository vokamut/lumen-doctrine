<?php

namespace Tests\TestCases;

use App\Database\Importers\Services\CustomerServiceImporterInterface;
use App\Database\Sources\Customer\CustomerSourceInterface;

class NoUniqueTestService implements CustomerServiceImporterInterface
{
    final public function getUsers(int $count): array
    {
        $users = [];

        for ($i = 0; $i < $count; ++$i) {
            $users[] = [
                'firstname' => $i . 'Firstname',
                'lastname' => $i . 'Lastname',
                'email' => 'nouniqueemail' . ($i % 2) . '@example.com',
                'country' => $i . 'Country',
                'city' => $i . 'City',
                'username' => $i . 'Username',
                'gender' => $i % 2 === 0,
                'phone' => $i . '123456789',
            ];
        }

        return $users;
    }

    final public function getSource(array $user): CustomerSourceInterface
    {
        return new TestServiceSource($user);
    }
}
