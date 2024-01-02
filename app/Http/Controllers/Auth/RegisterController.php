<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\User\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyRegistration;
use App\Models\User\Password;
use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::register(
            $request->login,
            $request->email,
            Password::create($request->password),
            Arr::random(Storage::disk('public')->files('avatar')),
        );

        Event::dispatch(new UserRegistered($user));

        Auth::login($user);

        return redirect()->route('register.prompt');
    }

    public function prompt(): Response
    {
        return Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
        ]);
    }

    public function notify(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->verify_token) {
            return redirect()->route('register.prompt')
                ->with('status', 'Verification not requested');
        }

        Mail::to($user->email)->send(new VerifyRegistration($user));

        return redirect()->route('register.prompt')
            ->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        try {
            Auth::user()->verifyRegistration($request->token);
        } catch (DomainException $e) {
            return redirect()->route('register.prompt')
                ->with('status', $e->getMessage());
        }

        return redirect(RouteServiceProvider::HOME . '?verified=1');
    }
}
