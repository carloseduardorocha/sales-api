<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Contracts\AuthContract;
use App\Http\Requests\LoginRequest;
use App\Exceptions\ErrorOnAuthUserException;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthContract $auth_service)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data     = $request->validated();
        $feedback = $this->auth_service->login($data['email'], $data['password']); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource(['data' => $feedback]), Response::HTTP_OK, 'User logged successfully!');
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        if (is_null($user))
        {
            throw new ErrorOnAuthUserException();
        }

        $this->auth_service->logout($user);

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'User logged out successfully!');
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();

        if (is_null($user))
        {
            throw new ErrorOnAuthUserException();
        }

        $data = $this->auth_service->me($user);

        return ApiResponse::jsonSuccess(new JsonResource(['data' => $data]), Response::HTTP_OK, 'User informations successfully obtained!');
    }
}
