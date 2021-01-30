<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Entities\Customer;
use App\Database\Repositories\CustomerRepository;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    private $customers;

    public function __construct(CustomerRepository $customers)
    {
        $this->customers = $customers;
    }

    /**
     * @return JsonResponse
     */
    final public function index(): JsonResponse
    {
        /** @var Customer[] $customers */
        $customers = $this->customers->findAll();

        return response()->json(array_map(function (Customer $customer) {
            return $customer->toArrayForList();
        }, $customers));
    }

    /**
     * @param int $customerId
     *
     * @return JsonResponse
     */
    final public function show(int $customerId): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $this->customers->find($customerId);

        if ($customer === null) {
            abort(404);
        }

        return response()->json($customer->toArray());
    }
}
