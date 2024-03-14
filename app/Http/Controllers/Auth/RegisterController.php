<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\User\UserRegistered;
use App\Exceptions\User\VerificationNotRequested;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyRegistration;
use App\Models\Notification;
use App\Models\User\Password;
use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
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
            $request->email,
            $request->username,
            Password::create($request->password),
        );

        Event::dispatch(new UserRegistered($user));

        Auth::login($user);

        return redirect()
            ->route('register.prompt')
            ->with('notification', Notification::success(trans('user.verification_sent')));
    }

    public function prompt(): Response
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    public function notify(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->verify_token) {
            throw new VerificationNotRequested();
        }

        Mail::to($user->email)->send(new VerifyRegistration($user));

        return redirect()
            ->route('register.prompt')
            ->with('notification', Notification::success(trans('user.verification_sent')));
    }

    public function verify(Request $request): RedirectResponse
    {
        try {
            Auth::user()->verifyRegistration($request->token);
        } catch (DomainException $e) {
            return redirect()
                ->route('register.prompt')
                ->with('notification', Notification::error($e->getMessage()));
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
