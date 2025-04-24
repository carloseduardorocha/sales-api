<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface AuthContract
{
    /**
     * Log in a user and issue an API token.
     *
     * @param string $email
     * @param string $password
     *
     * @return array<mixed>
     */
    public function login(string $email, string $password): array;

    /**
     * Log out a user by deleting their current access token.
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void;

    /**
     * Get the authenticated user's information.
     *
     * @param User $user
     * @return array<mixed>
     */
    public function me(User $user): array;
}
