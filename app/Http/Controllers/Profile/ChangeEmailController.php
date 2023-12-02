<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangeEmailRequest;
use App\Service\Profile\EmailUpdateService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChangeEmailController extends Controller
{
    public function __construct(private readonly EmailUpdateService $service)
    {
    }

    public function change(ChangeEmailRequest $request): RedirectResponse
    {
        $this->service->changeEmail($request->user(), $request->email);

        return redirect()
            ->route('profile')
            ->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        try {
            $this->service->verifyEmail($request->user(), $request->token);
        } catch (DomainException $e) {
            return redirect()
                ->route('profile')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('profile')
            ->with('status', 'Email successfully changed');
    }
}
