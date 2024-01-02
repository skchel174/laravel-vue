<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordRecoveryRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Mail\ResetPassword;
use App\Models\User\Password;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    public function email(PasswordResetRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::whereEmail($request->email)->firstOrFail();

        $user->update(['verify_token' => VerifyToken::create()]);

        Mail::to($user->email)->send(new ResetPassword($user));

        return redirect()->route('login')
            ->with('status', 'We have emailed your password reset link');
    }

    public function form(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->route('token'),
        ]);
    }

    public function reset(PasswordRecoveryRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::whereVerifyToken($request->token)->firstOrFail();

        try {
            $user->resetPassword(Password::create($request->password));
        } catch (DomainException $e) {
            return redirect()->route('login')
                ->with('error', $e->getMessage());
        }

        Session::invalidate();

        return redirect()->route('login')
            ->with('status', 'Your password has been reset');
    }
}
