<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function updateUserPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => bcrypt($password),
        ])->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    }
}
