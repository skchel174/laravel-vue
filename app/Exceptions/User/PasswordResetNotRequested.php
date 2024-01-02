<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class PasswordResetNotRequested extends DomainException
{
    public function __construct()
    {
        parent::__construct('Password reset not requested');
    }
}
