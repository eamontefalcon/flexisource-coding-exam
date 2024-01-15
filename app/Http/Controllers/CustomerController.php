<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Renderers\Customer\CustomerRenderer;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{

    private EntityManagerInterface $entityManager;
    private CustomerRenderer $customerRenderer;

    public function __construct(EntityManagerInterface $entityManager, CustomerRenderer $customerRenderer)
    {
        $this->entityManager = $entityManager;
        $this->customerRenderer = $customerRenderer;
    }

    public function index(): JsonResponse
    {
        $customers = $this->entityManager->getRepository(Customer::class)->findAll();

        return response()->json(['data' => $this->customerRenderer->renderArray($customers)]);
    }

    public function show(string $customerId): JsonResponse
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($customerId);

        if (null === $customer) {
            abort(404);
        }

        return response()->json(['data' => $this->customerRenderer->render($customer)]);
    }
}
