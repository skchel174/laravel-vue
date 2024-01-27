<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class VerificationTokenExpired extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('user.expired_token'));
    }
}
