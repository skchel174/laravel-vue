<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangePageSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function __invoke(ChangePageSettingsRequest $request): RedirectResponse
    {
        Session::put('view', $request->view);
        Session::put('langs', $request->langs);
        Session::put('locale', $request->locale);

        return redirect()->back();
    }
}
