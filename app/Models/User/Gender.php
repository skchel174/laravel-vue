<?php

declare(strict_types=1);

namespace App\Models\User;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
}
