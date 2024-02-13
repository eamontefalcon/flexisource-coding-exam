<?php

namespace App\Repositories\Customer;

use Doctrine\Persistence\ObjectRepository;

interface CustomerRepositoryInterface extends ObjectRepository
{
    public function createBulkCustomer(array $customersData, ?int $batchSize): void;
}
