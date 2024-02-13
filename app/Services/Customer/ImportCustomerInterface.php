<?php

namespace App\Services\Customer;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

interface ImportCustomerInterface
{
    public function getCustomers(int $importCount, string $nationality = null): JsonResponse | array;
}
