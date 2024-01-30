<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class BookmarkNotCreated extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('user.bookmark_not_created'));
    }
}
