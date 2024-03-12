<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangeEmailRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\ProfileDeleteRequest;
use App\Models\Notification;
use App\Models\User\Password;
use App\Models\User\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Settings/Account/AccountPage');
    }

    public function changeEmail(ChangeEmailRequest $request): RedirectResponse
    {
        Auth::user()->changeEmail($request->email);

        return redirect()
            ->route('settings.account')
            ->with('notification', Notification::success(trans('user.verification_sent')));
    }

    public function verifyEmail(Request $request): RedirectResponse
    {
        try {
            Auth::user()->verifyNewEmail($request->token);
        } catch (DomainException $e) {
            return redirect()
                ->route('profile')
                ->with('notification', Notification::error($e->getMessage()));
        }

        return redirect()
            ->route('settings.account')
            ->with('notification', Notification::success(trans('user.email_changed')));
    }

    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        Auth::user()->changePassword(Password::create($request->password));

        Auth::logout();

        Session::invalidate();

        return redirect()
            ->route('login')
            ->with('notification', Notification::success(trans('user.password_changed')));
    }

    public function delete(ProfileDeleteRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        Auth::logout();

        $user->delete();

        Session::invalidate();

        Session::regenerateToken();

        return redirect()
            ->route('main')
            ->with('notification', Notification::success(trans('user.account_deleted')));
    }
}
