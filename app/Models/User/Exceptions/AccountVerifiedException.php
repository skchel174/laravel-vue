<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class AccountVerifiedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Your account already verified.');
    }
}
