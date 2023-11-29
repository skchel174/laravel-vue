<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordRecoveryRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\User\Exceptions\PasswordResetNotRequested;
use App\Models\User\Exceptions\VerificationTokenExpired;
use App\Service\Auth\ResetPasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetController extends Controller
{
    public function __construct(private readonly ResetPasswordService $service)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    public function email(PasswordResetRequest $request): RedirectResponse
    {
        $this->service->sendVerificationEmail($request->email);

        return redirect()
            ->route('login.form')
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
        try {
            $this->service->changePassword($request->password, $request->token);
        } catch (PasswordResetNotRequested|VerificationTokenExpired $e) {
            return redirect()
                ->route('login.form')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('login.form')
            ->with('status', 'Your password has been reset');
    }
}
