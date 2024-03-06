<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PrivacyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Settings/Privacy/PrivacyPage');
    }
}
