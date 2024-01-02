<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class BookmarkNotCreated extends DomainException
{
    public function __construct()
    {
        parent::__construct('The bookmark has not yet been created');
    }
}
