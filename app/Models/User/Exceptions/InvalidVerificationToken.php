<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class InvalidVerificationToken extends DomainException
{
    public function __construct()
    {
        parent::__construct('Invalid verification token');
    }
}
