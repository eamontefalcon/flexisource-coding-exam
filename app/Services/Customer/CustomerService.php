<?php

namespace App\Services\Customer;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\DTO\GetCustomerDTO;
use App\Helpers\HttpHelper;

class CustomerService
{
    /**
     * @throws Exception
     */
    public function getCustomers(int $importCount, string $nationality = null): JsonResponse | array
    {

        $parameter = '?results='.$importCount;
        if ($nationality) {
            $parameter .= '&nat='.$nationality;
        }

        /** @var Response $response */
        $response = Http::customer()->get($parameter);

        $response = HttpHelper::tryCatchHttp($response);

        if ($response->status() === 500) {
            return $response;
        }

        return $this->setApiResponse($response);
    }

    public function setApiResponse($response): array
    {
        return (new GetCustomerDTO($response))->getResults();
    }
}