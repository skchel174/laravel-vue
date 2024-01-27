<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
            'error' => session('error'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::whereLogin($request->login)->firstOrFail();

        if (!$user->password->isEquals($request->password)) {
            throw ValidationException::withMessages(['password' => 'The provided password is incorrect']);
        }

        if (!$user->status->isActive()) {
            return redirect()->route('login')
                ->with('error', trans('user.not_active'));
        }

        Auth::login($user, (bool)$request->remember);

        Session::regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        Session::invalidate();

        Session::regenerateToken();

        return redirect()->route('main');
    }
}
