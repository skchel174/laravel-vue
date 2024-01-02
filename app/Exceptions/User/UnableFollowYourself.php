<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;

class UnableFollowYourself extends DomainException
{
    public function __construct()
    {
        parent::__construct('Unable to follow yourself');
    }
}
