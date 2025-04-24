<?php

namespace App\Exceptions;

use Exception;

use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class SaleNotFoundException extends Exception
{
    /** Convert exception into HTTP response */
    public function render(): JsonResponse
    {
        return ApiResponse::jsonException(Response::HTTP_NOT_FOUND, 'Sale not found.', class_basename($this));
    }
}
