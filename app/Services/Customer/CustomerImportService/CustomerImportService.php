<?php

namespace App\Services\Customer\CustomerImportService;

use App\Services\Customer\CreateCustomerService\CreateCustomerService;
use App\Services\Customer\CustomerInterface;
use App\Services\Customer\CustomerService;

class CustomerImportService
{
    private CreateCustomerService $createCustomerService;

    private CustomerInterface $customer;

    public function __construct(CreateCustomerService $createCustomerService, CustomerInterface $customer)
    {
        $this->createCustomerService = $createCustomerService;
        $this->customer = $customer;
    }

    /**
     * @throws \Exception
     */
    public function handle(int $importCount, string $nationality): void
    {
        $customers = $this->customer->getCustomers($importCount, $nationality);

        $this->createCustomerService->createBulkCustomer($customers);
    }
}
