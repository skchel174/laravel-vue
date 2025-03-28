<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class VerificationNotRequestedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Verification not requested');
    }
}
