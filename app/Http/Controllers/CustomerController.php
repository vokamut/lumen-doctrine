<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([]);
    }

    /**
     * @param int $customerId
     *
     * @return JsonResponse
     */
    public function show(int $customerId): JsonResponse
    {
        return response()->json([
            'id' => $customerId,
        ]);
    }
}
