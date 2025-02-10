<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePassRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->authService->signUp($request->all());
        Auth::login($user);

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
        if ($this->authService->signIn($credentials)) {
            return redirect()->intended($this->authService->getRedirectDependsOnRole());
        }

        return redirect()->intended('/login')->withErrors([
            'error' => 'Wrong email or password!',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logOut();
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
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['error' => __($status)]);
    }

    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(UpdatePassRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        $status = Password::reset(
            $credentials,
            fn (User $user, string $password) => $this->authService->updateUserPassword($user, $password)
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
