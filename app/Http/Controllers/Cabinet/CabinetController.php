<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CabinetController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Cabinet/CabinetPage');
    }
}
