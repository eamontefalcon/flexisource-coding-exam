<?php

namespace App\Helpers;


use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

class HttpHelper
{
    /** this will allow us to modify the error response to all that is using this helper */
    public static function tryCatchHttp(Response $response): JsonResponse|Response
    {
        if ($response->status() === 500) {
            return response()->json(['error' => $response->toException()], 500);
        }

        return $response;
    }
}
