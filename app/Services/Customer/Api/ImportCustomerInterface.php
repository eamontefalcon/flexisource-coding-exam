<?php

namespace App\Services\Customer\Api;

use Illuminate\Http\JsonResponse;

interface ImportCustomerInterface
{
    public function getCustomers(int $importCount, ?string $nationality = null): JsonResponse|array;
}
