<?php
declare(strict_types=1);

namespace App\Importers;

use App\Database\Entities\Customer;
use App\Database\Factories\CustomerFactory;
use App\Database\Repositories\CustomerRepository;
use App\Database\Sources\Customer\RandomUserSource;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class RandomUserImporter
{
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://randomuser.me/api/',
            'http_errors' => false
        ]);
    }

    final public function importUsers(int $count): bool
    {
        if ($count < 1) {
            throw new RuntimeException('Count must be greater than 0');
        }

        $request = $this->httpClient->get('', [
            'headers' => [
                'accept' => 'application/json'
            ],
            'query' => [
                'format' => 'json',
                'nat' => 'au',
                'results' => $count,
                'inc' => 'gender,name,nat,location,email,login,phone',
                'noinfo' => '',
            ]
        ]);

        $statusCode = $request->getStatusCode();
        $bodyContents = $request->getBody()->getContents();

        if ($statusCode !== 200) {
            Log::error(sprintf('randomuser.me returned[%s] status code', $statusCode));
            Log::error($bodyContents);

            return false;
        }

        $result = json_decode($bodyContents, true);

        Log::debug($result);

        $this->storeToDatabase($result);

        return true;
    }

    private function storeToDatabase(array $result): void
    {
        $customerRepository = app(CustomerRepository::class);

        foreach ($result['results'] as $user) {
            /** @var Customer|null $customer */
            $customer = $customerRepository->findOneByEmail($user['email']);

            if ($customer === null) {
                (new CustomerFactory(
                    new RandomUserSource($user)
                ))->create();
            } else {
                (new CustomerFactory(
                    new RandomUserSource($user)
                ))->update($customer->getId());
            }
        }
    }
}
