<?php

namespace App\Services\Customer\CustomerImportService;

use App\Services\Customer\CreateCustomerService\CreateCustomerService;
use App\Services\Customer\CustomerService;

class CustomerImportService
{
    private CreateCustomerService $createCustomerService;

    public function __construct(CreateCustomerService $createCustomerService)
    {
        $this->createCustomerService = $createCustomerService;
    }

    /**
     * @throws \Exception
     */
    public function handle(int $importCount, string $nationality): void
    {
        //TODO adjust this using interface later
        $customerService = new CustomerService();
        $customers = $customerService->getCustomers($importCount, $nationality);

        $this->createCustomerService->createBulkCustomer($customers);
    }
}
