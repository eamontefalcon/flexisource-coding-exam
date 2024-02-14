<?php

namespace App\Services\Customer\Api;

use App\Helpers\HttpHelper;
use App\Transformer\GetCustomerTransformer;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ImportCustomerService implements ImportCustomerInterface
{
    /**
     * Transform the api response
     *
     * @throws Exception
     */
    private function setApiResponse(Response $response): array
    {
        return (new GetCustomerTransformer($response))->getResults();
    }

    /**
     * Retrieves customer data from a third-party API.
     *
     * @throws Exception
     */
    public function getCustomers(int $importCount, string $nationality = null): JsonResponse | array
    {

        $parameter = '?results='.$importCount;
        if ($nationality) {
            $parameter .= '&nat='.$nationality;
        }

        /**
         * customer() method is in a service provider (HttpMacroServiceProvider)
         *
         * @var Response $response
         *
         */
        $response = Http::customer()->get($parameter);

        $response = HttpHelper::tryCatchHttp($response);

        if ($response->status() === 500) {
            return $response;
        }

        return $this->setApiResponse($response);
    }

}
