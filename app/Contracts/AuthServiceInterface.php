<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    /**
     *  Create a new user instance after a valid registration.
     *
     * @param array<string, string> $data
     * @return User
     */
    public function signUp(array $data): User;

    /**
     *  Signs in a user.
     *
     * @param array<string, string> $credentials
     * @return bool
     */
    public function signIn(array $credentials): bool;

    /**
     *  Signs out a user.
     *
     * @return void
     */
    public function logOut(): void;

    /**
     *  Returns the redirect route depends on user role.
     *
     * @return string
     */
    public function getRedirectDependsOnRole(): string;

    /**
     *  Updates user password.
     *
     * @param User $user
     * @param string $password
     */
    public function updateUserPassword(User $user, string $password): void;
}
