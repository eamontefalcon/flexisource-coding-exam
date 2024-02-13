<?php

namespace App\Services\Customer;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Transformer\GetCustomerTransformer;
use App\Helpers\HttpHelper;

class ImportCustomerService implements ImportCustomerInterface
{
    /**
     * @throws Exception
     */
    private function setApiResponse(Response $response): array
    {
        return (new GetCustomerTransformer($response))->getResults();
    }

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

}
