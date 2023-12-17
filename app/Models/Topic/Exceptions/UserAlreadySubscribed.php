<?php

declare(strict_types=1);

namespace App\Models\Topic\Exceptions;

use DomainException;

class UserAlreadySubscribed extends DomainException
{
    public function __construct()
    {
        parent::__construct('User already subscribed to the topic');
    }
}
