<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendNotificationRequest;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use App\Notifications\User\ResetPassword;
use App\Services\FlashNotifier;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

readonly class ResetPasswordController
{
    public function __construct(private FlashNotifier $notifier)
    {
    }

    public function notice(): Response
    {
        return Inertia::render('ResetPassword/NoticePage');
    }

    /**
     * @throws ValidationException
     */
    public function notify(SendNotificationRequest $request): RedirectResponse
    {
        if (!$user = User::firstWhere('email', $request->email)) {
            throw ValidationException::withMessages(['email' => trans('auth.email')]);
        }

        $user->update(['verify_token' => VerifyToken::create()]);

        $user->notify(new ResetPassword());

        $this->notifier->info(trans('passwords.sent'));

        return back();
    }

    public function form(User $user, string $token): Response
    {
        $user->checkVerifyToken($token);

        return Inertia::render('ResetPassword/ResetPasswordPage', [
            'user' => $user->id,
            'token' => $token,
        ]);
    }

    /**
     * @throws AuthenticationException
     */
    public function reset(ResetPasswordRequest $request, User $user, string $token): RedirectResponse
    {
        $user->resetPassword($request->password, $token);

        Auth::login($user);

        Auth::logoutOtherDevices($request->password);

        Auth::logoutCurrentDevice();

        $this->notifier->success(trans('passwords.reset'));

        return redirect()->route('login');
    }
}
