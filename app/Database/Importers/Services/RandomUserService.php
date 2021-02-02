<?php

declare(strict_types=1);

namespace App\Database\Importers\Services;

use App\Database\Sources\Customer\CustomerSourceInterface;
use App\Database\Sources\Customer\RandomUserSource;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RandomUserService implements CustomerServiceImporterInterface
{
    /**
     * @var Client
     */
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://randomuser.me/api/',
            'http_errors' => false,
        ]);
    }

    final public function getUsers(int $count): array
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $request = $this->httpClient->get('', [
            'headers' => [
                'accept' => 'application/json',
            ],
            'query' => [
                'format' => 'json',
                'nat' => 'au',
                'results' => $count,
                'inc' => 'gender,name,nat,location,email,login,phone',
                'noinfo' => '',
            ],
        ]);

        $statusCode = $request->getStatusCode();
        $bodyContents = $request->getBody()->getContents();

        if ($statusCode !== 200) {
            Log::error(sprintf('randomuser.me returned[%s] status code', $statusCode));
            Log::error($bodyContents);

            return [];
        }

        $result = json_decode($bodyContents, true, 512, JSON_THROW_ON_ERROR);

        return $result['results'];
    }

    final public function getSource(array $user): CustomerSourceInterface
    {
        return new RandomUserSource($user);
    }
}
