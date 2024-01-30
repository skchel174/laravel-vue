<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangeEmailRequest;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeEmailController extends Controller
{
    public function change(ChangeEmailRequest $request): RedirectResponse
    {
        Auth::user()->changeEmail($request->email);

        return redirect()->route('profile')
            ->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        try {
            Auth::user()->verifyNewEmail($request->token);
        } catch (DomainException $e) {
            return redirect()->route('profile')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('profile')
            ->with('status', trans('user.email_changed'));
    }
}
