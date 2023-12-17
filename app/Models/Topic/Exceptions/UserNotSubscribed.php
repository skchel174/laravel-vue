<?php

declare(strict_types=1);

namespace App\Models\Topic\Exceptions;

use DomainException;

class UserNotSubscribed extends DomainException
{
    public function __construct()
    {
        parent::__construct('user not subscribed to the topic');
    }
}
