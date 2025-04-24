<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Contracts\AuthContract;
use App\Exceptions\ErrorOnAuthUserException;

class AuthService implements AuthContract
{
    public function login(string $email, string $password): array
    {
        $user = User::where(User::EMAIL, $email)->first();

        if (!$user || !Hash::check($password, $user->password))
        {
            throw new ErrorOnAuthUserException();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    public function me(User $user): array
    {
        return $user->toArray();
    }
}
