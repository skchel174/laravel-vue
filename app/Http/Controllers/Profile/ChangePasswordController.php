<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Service\Profile\PasswordUpdateService;
use Illuminate\Http\RedirectResponse;

class ChangePasswordController extends Controller
{
    public function __construct(private readonly PasswordUpdateService $service)
    {
    }

    public function __invoke(ChangePasswordRequest $request): RedirectResponse
    {
        $this->service->changePassword($request->password);

        return redirect()
            ->route('login')
            ->with('status', 'Password successfully changed');
    }
}
