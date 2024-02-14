<?php

namespace App\Services\Customer\CustomerImportService;

use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Services\Customer\Api\ImportCustomerInterface;

class CustomerImportService
{
    /**
     * Initialize instances
     */
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private ImportCustomerInterface $importCustomer
    ) {
    }

    /**
     * Get customers data from third party api
     * then insert all that record to customers entity
     *
     * @throws \Exception
     */
    public function handle(int $importCount, string $nationality): void
    {
        $importCustomersData = $this->importCustomer->getCustomers($importCount, $nationality);
        $this->customerRepository->createBulkCustomer($importCustomersData);
    }
}
