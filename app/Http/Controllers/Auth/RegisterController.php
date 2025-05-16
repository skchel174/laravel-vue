<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User\User;
use App\Notifications\RegisterVerification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RegisterController extends Controller
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

        return redirect()->route('verification');
    }
}
