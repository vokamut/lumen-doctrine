<?php
declare(strict_types=1);

namespace Tests\Unit\App\Database\Importers;

use App\Database\Entities\Customer;
use App\Database\Importers\CustomerImporter;
use App\Http\Controllers\CustomerController;
use Tests\TestCases\TestCase;
use Tests\TestCases\TestService;

class CustomerImporterTest extends TestCase
{
    final public function testImport10Users(): void
    {
        $countUsers = 10;

        $testService = new TestService;
        $users = $testService->getUsers($countUsers);

        $customerImporter = new CustomerImporter(new TestService);

        self::assertTrue($customerImporter->import($countUsers));

        $repository = $this->entityManager->getRepository(Customer::class);
        $customerController = new CustomerController($this->customerRepository);

        foreach ($users as $user) {
            /** @var Customer $customer */
            $customer = $repository->findOneByEmail($user['email']);

            self::assertEquals($user['firstname'], $customer->getFirstname());
            self::assertEquals($user['lastname'], $customer->getLastname());
            self::assertEquals($user['email'], $customer->getEmail());
            self::assertEquals($user['country'], $customer->getCountry());
            self::assertEquals($user['city'], $customer->getCity());
            self::assertEquals($user['username'], $customer->getUsername());
            self::assertEquals($user['gender'], $customer->getGender());
            self::assertEquals($user['phone'], $customer->getPhone());

            $response = $customerController->show($customer->getId());

            self::assertEquals(200, $response->getStatusCode());

            $responseUser = $response->getData(true);

            self::assertEquals($customer->getId(), $responseUser['id']);
            self::assertEquals($user['firstname'] . ' ' . $user['lastname'], $responseUser['fullName']);
            self::assertEquals($user['email'], $responseUser['email']);
            self::assertEquals($user['country'], $responseUser['country']);
            self::assertEquals($user['city'], $responseUser['city']);
            self::assertEquals($user['username'], $responseUser['username']);
            self::assertEquals($user['gender'] === Customer::GENDER_MALE ? 'male' : 'female', $responseUser['gender']);
            self::assertEquals($user['phone'], $responseUser['phone']);
        }

        $responseList = $customerController->list();
        $responseListUsers = $responseList->getData(true);

        self::assertEquals(200, $responseList->getStatusCode());
        self::assertCount($countUsers, $responseListUsers);

        foreach ($responseListUsers as $responseListUser) {
            /** @var Customer $customer */
            $customer = $repository->find($responseListUser['id']);

            self::assertEquals($customer->getId(), $responseListUser['id']);
            self::assertEquals($customer->getFullName(), $responseListUser['fullName']);
            self::assertEquals($customer->getEmail(), $responseListUser['email']);
            self::assertEquals($customer->getCountry(), $responseListUser['country']);

            self::assertArrayNotHasKey('firstname', $responseListUser);
            self::assertArrayNotHasKey('lastname', $responseListUser);
            self::assertArrayNotHasKey('username', $responseListUser);
            self::assertArrayNotHasKey('gender', $responseListUser);
            self::assertArrayNotHasKey('phone', $responseListUser);
        }
    }
}
