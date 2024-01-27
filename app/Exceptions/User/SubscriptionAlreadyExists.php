<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class SubscriptionAlreadyExists extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('user.already_following'));
    }
}
