<?php

namespace App\Exceptions;

use Exception;

use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class SellerNotFoundException extends Exception
{
    /** Convert exception into HTTP response */
    public function render(): JsonResponse
    {
        return ApiResponse::jsonException(Response::HTTP_NOT_FOUND, 'Seller not found.', class_basename($this));
    }
}
