<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Contracts\RegisterServiceInterface;
use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcherInterface;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerInterface;
use Illuminate\Contracts\Auth\StatefulGuard as GuardInterface;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private PasswordBrokerInterface $passwordBroker,
        private GuardInterface $guard,
        private EventDispatcherInterface $eventDispatcher,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function signUp(array $data): void
    {
        $user = $this->userRepository->create($data);
        $this->eventDispatcher->dispatch(new Registered($user));
        $this->guard->login($user);
    }

    public function signIn(array $credentials): bool
    {
        return $this->guard->attempt($credentials);
    }

    public function logOut(): void
    {
        $this->guard->logout();
    }

    public function getRedirectDependsOnRole(): string
    {
        if ($this->checkAdminRole()) {
            return '/admin/products';
        }

        return '/';
    }

    public function updateUserPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => bcrypt($password),
        ])->setRememberToken(str()->random(60));
        $user->save();
        $this->eventDispatcher->dispatch(new PasswordReset($user));
    }

    public function sendResetLink(string $email): string
    {
        return $this->passwordBroker->sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $credentials): string
    {
        return $this->passwordBroker->reset(
            $credentials,
            fn(User $user, string $password) => $this->updateUserPassword($user, $password)
        );
    }

    public function checkAdminRole(): bool
    {
        return $this->guard->check() && $this->guard->user()?->role === UserRole::Admin->value;
    }

    public function checkUserRole(): bool
    {
        return $this->guard->check() && $this->guard->user()?->role === UserRole::User->value;
    }
}
