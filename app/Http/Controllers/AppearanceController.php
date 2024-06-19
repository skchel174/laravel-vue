<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppearanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class AppearanceController
{
    public function __invoke(UpdateAppearanceRequest $request): RedirectResponse
    {
        Session::put($request->only(['locale']));

        return back();
    }
}
