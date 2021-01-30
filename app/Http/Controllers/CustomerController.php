<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Entities\Customer;
use App\Database\Repositories\CustomerRepository;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return JsonResponse
     */
    final public function index(): JsonResponse
    {
        return response()->json($this->customerRepository->findAllForList());
    }

    /**
     * @param int $customerId
     *
     * @return JsonResponse
     */
    final public function show(int $customerId): JsonResponse
    {
        /** @var Customer|null $customer */
        $customer = $this->customerRepository->find($customerId);

        if ($customer === null) {
            return response()->json(
                ['message' => sprintf('Customer[%s] not found', $customerId)],
                404
            );
        }

        return response()->json($customer->toArray());
    }
}
