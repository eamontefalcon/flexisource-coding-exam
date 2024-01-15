<?php

namespace App\Services\Customer;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

interface CustomerInterface
{
    public function getCustomers(int $importCount, string $nationality = null): JsonResponse | array;
}
