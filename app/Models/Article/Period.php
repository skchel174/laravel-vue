<?php

declare(strict_types=1);

namespace App\Models\Article;

enum Period: string
{
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';
}
