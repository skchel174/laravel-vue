<?php

declare(strict_types=1);

namespace App\Exceptions\Comment;

use DomainException;

class ExceededEditingTimeLimit extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('comment.edit_time_exceeded'));
    }
}
