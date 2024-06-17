<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\User;
use App\Notifications\User\VerifyRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController
{
    public function index(): Response
    {
        return Inertia::render('Registration/RegisterPage');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::register(
            $request->email,
            $request->username,
            $request->password,
        );

        Auth::login($user);

        $user->notify(new VerifyRegistration());

        return redirect()->route('register.notice');
    }

    public function notice(): Response
    {
        return Inertia::render('Registration/NoticePage');
    }

    public function notify(): RedirectResponse
    {
        $user = Auth::user();

        $user->verifyToken->regenerate();

        $user->notify(new VerifyRegistration());

        return back();
    }

    public function verify(string $token): RedirectResponse
    {
        $user = Auth::user();

        $user->verify($token);

        return redirect()->intended();
    }
}
