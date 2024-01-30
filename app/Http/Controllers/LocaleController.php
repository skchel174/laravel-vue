<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SetLocaleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function __invoke(SetLocaleRequest $request): RedirectResponse
    {
        Session::put('locale', $request->locale);
        Session::put('content_langs', $request->content_langs);

        return redirect()->back();
    }
}
