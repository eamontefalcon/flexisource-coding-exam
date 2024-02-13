<?php

namespace App\Services\Customer\CustomerImportService;

use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Services\Customer\ImportCustomerInterface;

class CustomerImportService
{
    private ImportCustomerInterface $importCustomer;
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, ImportCustomerInterface $importCustomer)
    {
        $this->importCustomer = $importCustomer;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws \Exception
     *
     * Get customers data from third party api
     * then insert all that record to customers entity
     *
     */
    public function handle(int $importCount, string $nationality): void
    {
        $importCustomersData = $this->importCustomer->getCustomers($importCount, $nationality);
        $this->customerRepository->createBulkCustomer($importCustomersData);
    }
}
