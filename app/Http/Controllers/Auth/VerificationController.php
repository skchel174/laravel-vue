<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use App\Notifications\RegisterVerification;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use Inertia\Inertia;

class VerificationController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Auth/VerificationPage');
    }

    public function send(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->regenerateVerifyToken();

        $user->notify(new RegisterVerification());

        return redirect()
            ->route('verification')
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
