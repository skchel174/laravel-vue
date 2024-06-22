<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangeLocaleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocalizationController
{
    public function __invoke(ChangeLocaleRequest $request): RedirectResponse
    {
        Session::put(['locale' => $request->locale]);

        return back();
    }
}
