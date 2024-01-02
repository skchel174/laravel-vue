<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class RegistrationAlreadyVerified extends DomainException
{
    public function __construct()
    {
        parent::__construct('Registration already verified');
    }
}
