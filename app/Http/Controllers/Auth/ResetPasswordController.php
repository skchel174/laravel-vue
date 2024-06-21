<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController
{
    public function notice(): Response
    {
        return Inertia::render('ResetPassword/NoticePage');
    }
}
