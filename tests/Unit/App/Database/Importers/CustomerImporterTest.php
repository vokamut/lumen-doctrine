<?php

declare(strict_types=1);

namespace Tests\Unit\App\Database\Importers;

use App\Database\Entities\Customer;
use App\Database\Importers\CustomerImporter;
use App\Http\Controllers\CustomerController;
use Tests\TestCases\NoUniqueTestService;
use Tests\TestCases\TestCase;
use Tests\TestCases\UniqueTestService;

class CustomerImporterTest extends TestCase
{
    final public function testImport10UniqueUsers(): void
    {
        $countUsers = 10;

        $testService = new UniqueTestService;
        $users = $testService->getUsers($countUsers);

        $customerImporter = new CustomerImporter(new UniqueTestService);

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

    final public function testImport10NoUniqueUsers(): void
    {
        $countUsers = 10;

        $testService = new NoUniqueTestService;
        $users = $testService->getUsers($countUsers);

        $users = array_reverse($users);

        $customerImporter = new CustomerImporter(new NoUniqueTestService);

        self::assertTrue($customerImporter->import($countUsers));

        $repository = $this->entityManager->getRepository(Customer::class);
        $customerController = new CustomerController($this->customerRepository);

        $assertsUserEmails = [];

        foreach ($users as $index => $user) {
            /** @var Customer $customer */
            $customer = $repository->findOneByEmail($user['email']);

            if (array_key_exists($user['email'], $assertsUserEmails)) {
                self::assertNotEquals($user['firstname'], $customer->getFirstname());
                self::assertNotEquals($user['lastname'], $customer->getLastname());
                self::assertEquals($user['email'], $customer->getEmail());
                self::assertNotEquals($user['country'], $customer->getCountry());
                self::assertNotEquals($user['city'], $customer->getCity());
                self::assertNotEquals($user['username'], $customer->getUsername());
                self::assertEquals($user['gender'], $customer->getGender());
                self::assertNotEquals($user['phone'], $customer->getPhone());

                $response = $customerController->show($customer->getId());

                self::assertEquals(200, $response->getStatusCode());

                $responseUser = $response->getData(true);

                self::assertEquals($customer->getId(), $responseUser['id']);
                self::assertNotEquals($user['firstname'] . ' ' . $user['lastname'], $responseUser['fullName']);
                self::assertEquals($user['email'], $responseUser['email']);
                self::assertNotEquals($user['country'], $responseUser['country']);
                self::assertNotEquals($user['city'], $responseUser['city']);
                self::assertNotEquals($user['username'], $responseUser['username']);
                self::assertEquals($user['gender'] === Customer::GENDER_MALE ? 'male' : 'female', $responseUser['gender']);
                self::assertNotEquals($user['phone'], $responseUser['phone']);
            } else {
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

                $assertsUserEmails[$user['email']] = true;
            }
        }

        $responseList = $customerController->list();
        $responseListUsers = $responseList->getData(true);

        self::assertEquals(200, $responseList->getStatusCode());
        self::assertCount(count($assertsUserEmails), $responseListUsers);

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
