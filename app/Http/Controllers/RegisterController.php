<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User\User;
use App\Notifications\RegisterVerification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RegisterController
{
    public function form(): InertiaResponse
    {
        return Inertia::render('Auth/RegisterPage');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::register(
            $request->email,
            $request->username,
            $request->password,
        );

        auth()->login($user);

        $user->notify(new RegisterVerification());

        return redirect()->route('register.report');
    }

    public function report(): InertiaResponse
    {
        return Inertia::render('Auth/ReportPage');
    }

    public function resend(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->regenerateVerifyToken();
        $user->notify(new RegisterVerification());

        return redirect()
            ->route('register.report')
            ->with('message', 'A new verification link has been sent to the email address you provided during registration.');
    }

    public function verify(string $token): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->verify($token);

        return redirect()
            ->route('profile')
            ->with('message', 'Your account has been verified.');
    }
}
