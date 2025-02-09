<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function __construct()
    {
    }

    public function createUser(array $data): User
    {
        $user = User::create($data);
        event(new Registered($user));
        return $user;
    }

    public function signIn(array $credentials): bool
    {
        if (Auth::attempt($credentials)) {
            Log::info('User authenticated', ['user_id' => Auth::id()]);
            session()->regenerate();
            Log::info('Session regenerated', ['session' => session()->all()]);

            return true;
        }

        return false;
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
}
