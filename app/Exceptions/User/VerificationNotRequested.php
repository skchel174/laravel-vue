<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class VerificationNotRequested extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('user.no_verification_request'));
    }
}
