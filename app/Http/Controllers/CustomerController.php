<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Renderers\Customer\CustomerRenderer;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Initialize instances
     */
    public function __construct(
        public CustomerRepositoryInterface $customerRepository,
        public CustomerRenderer $customerRenderer
    ) { }

    /**
     * Get list of customers
     * return api resource
     */
    public function index(): JsonResponse
    {
        $customers = $this->customerRepository->findAll();

        return response()->json(['data' => $this->customerRenderer->renderArray($customers)]);
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

        return response()->json(['data' => $this->customerRenderer->render($customer)]);
    }
}
