<?php

namespace Tests\Unit\Helpers;

use App\Helpers\ApiResponse;
use App\Enums\Error;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ApiResponseTest extends TestCase
{
    public function test_format_returns_successful_response(): void
    {
        $data = ['key' => 'value'];
        $response = ApiResponse::format(true, $data, 'Success message');

        $this->assertEquals([
            'data'    => $data,
            'success' => true,
            'message' => 'Success message',
        ], $response);
    }

    public function test_format_returns_failure_response_with_error_slug(): void
    {
        $data = [];
        $response = ApiResponse::format(false, $data, 'Error message', 'error_slug');

        $this->assertEquals([
            'data'       => $data,
            'success'    => false,
            'message'    => 'Error message',
            'error_slug' => 'error_slug',
        ], $response);
    }

    public function test_json_success_returns_json_response(): void
    {
        $resource = new JsonResource(['key' => 'value']);
        $response = ApiResponse::jsonSuccess($resource, 200, 'Success message');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData(true);
        $this->assertTrue($data['success']);
        $this->assertEquals('Success message', $data['message']);
        $this->assertArrayHasKey('data', $data);
    }

    public function test_json_error_returns_json_response(): void
    {
        $resource = new JsonResource(['error' => 'value']);
        $response = ApiResponse::jsonError($resource, 400, 'Error message');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());

        $data = $response->getData(true);
        $this->assertFalse($data['success']);
        $this->assertEquals('Error message', $data['message']);
        $this->assertArrayHasKey('data', $data);
    }

    public function test_json_exception_returns_json_response(): void
    {
        $response = ApiResponse::jsonException(500, 'Internal Server Error', 'internal_error');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());

        $data = $response->getData(true);
        $this->assertFalse($data['success']);
        $this->assertEquals('Internal Server Error', $data['message']);
        $this->assertEquals('internal_error', $data['error_slug']);
    }

    public function test_json_request_validation_error_throws_http_response_exception(): void
    {
        $validator = Validator::make(
            ['email' => 'invalid-email'],
            ['email' => 'required|email']
        );

        try {
            ApiResponse::jsonRequestValidationError($validator);
            $this->fail('Expected HttpResponseException was not thrown.');
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
            $this->assertInstanceOf(JsonResponse::class, $response);
            $this->assertEquals(422, $response->getStatusCode());

            $data = $response->getData(true);
            $this->assertFalse($data['success']);
            $this->assertEquals('Request validation errors.', $data['message']);
            $this->assertEquals(Error::REQUEST_VALIDATION_ERROR->value, $data['error_slug']);
            $this->assertArrayHasKey('data', $data);
        }
    }

    public function test_json_request_forbidden_throws_http_response_exception(): void
    {
        try {
            ApiResponse::jsonRequestForbidden();
            $this->fail('Expected HttpResponseException was not thrown.');
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
            $this->assertInstanceOf(JsonResponse::class, $response);
            $this->assertEquals(403, $response->getStatusCode());

            $data = $response->getData(true);
            $this->assertFalse($data['success']);
            $this->assertEquals('This action is forbidden.', $data['message']);
            $this->assertEquals(Error::REQUEST_ACTION_FORBIDDEN->value, $data['error_slug']);
        }
    }
}
