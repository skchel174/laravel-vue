<?php

declare(strict_types=1);

namespace App\Models\User;

enum Status: string
{
    case Wait = 'wait';
    case Active = 'active';
}
