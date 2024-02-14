<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Initialize instances
     */
    public function __construct(
        public CustomerRepositoryInterface $customerRepository
    ) { }

    /**
     * Get list of customers
     */
    public function index(): JsonResponse
    {
        $customers = $this->customerRepository->findAll();

        return response()->json(['data' => CustomerResource::collection($customers)]);
    }

    /**
     * Show data of customer base on id
     */
    public function show(string $customerId): JsonResponse
    {
        $customer = $this->customerRepository->find($customerId);

        if (null === $customer) {
            abort(404);
        }

        return response()->json(['data' => (new CustomerResource($customer))->customerInformation()]);
    }
}
