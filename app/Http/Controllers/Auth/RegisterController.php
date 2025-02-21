<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Contracts\RegisterServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePassRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(
        private RegisterServiceInterface $registerService,
    ) {
    }
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->registerService->signUp($request->validated());

        return redirect()->route('verification.notice');
    }

    public function verifyEmail(): View
    {
        return view('auth.verify-email');
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(AuthUserRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if ($this->registerService->signIn($credentials)) {
            session()->regenerate();

            return redirect()->intended($this->registerService->getRedirectDependsOnRole());
        }

        return redirect()->intended('/login')->withErrors([
            'error' => 'Wrong email or password!',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->registerService->logOut();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot');
    }

    public function sendResetLink(SendResetLinkRequest $request): RedirectResponse
    {
        $status = $this->registerService->sendResetLink($request->email);

        return $status === PasswordBroker::RESET_LINK_SENT
            ? back()->with(['success' => $status])
            : back()->withErrors(['error' => $status]);
    }

    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(UpdatePassRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        $status = $this->registerService->resetPassword($credentials);

        return $status === PasswordBroker::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
