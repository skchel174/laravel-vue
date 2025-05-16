<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class AlreadyVerifiedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('User is already verified');
    }
}
