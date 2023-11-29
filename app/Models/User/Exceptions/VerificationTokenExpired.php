<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class VerificationTokenExpired extends DomainException
{
    public function __construct()
    {
        parent::__construct('Verification token expired');
    }
}
