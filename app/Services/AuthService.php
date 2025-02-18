<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthService implements AuthServiceInterface
{
    public function signUp(array $data): User
    {
        $user = User::create($data);
        event(new Registered($user));

        return $user;
    }

    public function signIn(array $credentials): bool
    {
        return (Auth::attempt($credentials));
    }

    public function logOut(): void
    {
        Auth::logout();
    }

    public function getRedirectDependsOnRole(): string
    {
        if (Auth::check() && Auth::user()?->role === 'admin') {
            return '/admin/products';
        }

        return '/';
    }

    public function updateUserPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => bcrypt($password),
        ])->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    }

    public static function checkAdminRole(): bool
    {
        return Auth::check() && Auth::user()?->role === UserRole::Admin->value;
    }

    public static function checkUserRole(): bool
    {
        return Auth::check() && Auth::user()?->role === UserRole::User->value;
    }
}
