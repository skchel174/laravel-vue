<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class SubscriptionNotExists extends DomainException
{
    public function __construct()
    {
        parent::__construct('You are not following this user');
    }
}
