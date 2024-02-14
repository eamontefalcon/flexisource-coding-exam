<?php

namespace App\Services\Customer\Api;

use App\Transformer\GetCustomerTransformer;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerImportService implements CustomerImportInterface
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
    public function getCustomers(int $importCount, ?string $nationality = null): JsonResponse|array
    {

        // Construct query parameters for the API request.
        $queryParameters = ['results' => $importCount];

        // Include the 'nationality' parameter if provided.
        if ($nationality) {
            $queryParameters['nat'] = $nationality;
        }

        // Build the query string from the parameters.
        $parameter = '?'.http_build_query($queryParameters);

        /**
         * Makes a GET request to the customer API endpoint using the 'customer' macro.
         * The 'customer' macro is defined in the HttpMacroServiceProvider service provider.
         *
         * @var Response $response
         */
        $response = Http::customer()->get($parameter);

        if ($response->failed()) {
            Log::error($response->toException());

            return response()->json(['error' => $response->status()], $response->status());
        }

        return $this->setApiResponse($response);
    }
}
