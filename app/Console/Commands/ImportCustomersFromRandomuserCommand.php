<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Database\Entities\Customer;
use App\Database\Factories\CustomerFactory;
use App\Database\Repositories\CustomerRepository;
use App\Database\Sources\Customer\RandomUserSource;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportCustomersFromRandomuserCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:customers:from:randomuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import customers from randomuser.me service.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    final public function handle(): int
    {
        $httpClient = new Client([
            'base_uri' => 'https://randomuser.me/api/',
            'http_errors' => false
        ]);

        $request = $httpClient->get('', [
            'headers' => [
                'accept' => 'application/json'
            ],
            'query' => [
                'format' => 'json',
                'nat' => 'au',
                'results' => '100',
                'inc' => 'gender,name,nat,location,email,login,phone'
            ]
        ]);

        $statusCode = $request->getStatusCode();
        $bodyContents = $request->getBody()->getContents();

        if ($statusCode !== 200) {
            $this->error(sprintf('randomuser.me returned[%s] status code', $statusCode));
            $this->error($bodyContents);

            return 1;
        }

        /** @var CustomerRepository $customerRepository */
        $customerRepository = app(CustomerRepository::class);

        $result = json_decode($bodyContents, true);

        $bar = $this->output->createProgressBar(count($result['results']));

        $createdCustomers = $updatedCustomers = 0;

        foreach ($result['results'] as $user) {
            /** @var Customer|null $customer */
            $customer = $customerRepository->findOneByEmail($user['email']);

            if ($customer === null) {
                (new CustomerFactory(
                    new RandomUserSource($user)
                ))->create();

                ++$createdCustomers;
            } else {
                (new CustomerFactory(
                    new RandomUserSource($user)
                ))->update($customer->getId());

                ++$updatedCustomers;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->line('');

        $this->info("{$createdCustomers} customers created");
        $this->info("{$updatedCustomers} customers updated");

        return 0;
    }
}
