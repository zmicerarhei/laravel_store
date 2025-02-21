<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface RegisterServiceInterface
{
    /**
     *  Create a new user instance after a valid registration.
     *
     * @param array<string, string> $data
     * @return void
     */
    public function signUp(array $data): void;

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

    /**
     *  Checks admin role.
     *
     * @return bool
     */
    public function checkAdminRole(): bool;

    /**
     *  Checks user role.
     *
     * @return bool
     */
    public function checkUserRole(): bool;

    /**
     *  Sends password reset link.
     *
     * @param string $email
     * @return string
     */
    public function sendResetLink(string $email): string;

    /**
     *  Resets password.
     *
     * @param array<string, string> $credentials
     * @return string
     */
    public function resetPassword(array $credentials): string;
}
