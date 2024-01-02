<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class AccountNotActive extends DomainException
{
    public function __construct()
    {
        parent::__construct('User account not active.');
    }
}
