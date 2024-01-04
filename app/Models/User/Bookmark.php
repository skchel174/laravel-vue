<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Bookmark extends Pivot
{
    protected $table = 'bookmarks';
}
