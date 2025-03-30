<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RegisterController
{
    public function form(): InertiaResponse
    {
        return Inertia::render('Auth/RegisterPage');
    }
}
