<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthSessionController
{
    public function index(): Response
    {
        return Inertia::render('Login/LoginPage');
    }

    /**
     * @throws ValidationException
     */
    public function create(LoginRequest $request): RedirectResponse
    {
        if (!$user = User::firstWhere('email', $request->email)) {
            throw ValidationException::withMessages(['email' => trans('auth.email')]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['password' => trans('auth.password')]);
        }

        Auth::login($user, $request->remember);

        Session::regenerate();

        return redirect()->intended();
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();

        Session::invalidate();

        Session::regenerateToken();

        return redirect('/');
    }
}
