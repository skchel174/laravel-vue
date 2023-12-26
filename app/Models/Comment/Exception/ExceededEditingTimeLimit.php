<?php

declare(strict_types=1);

namespace App\Models\Comment\Exception;

use DomainException;

class ExceededEditingTimeLimit extends DomainException
{
    public function __construct()
    {
        parent::__construct('Comments may be edited for 30 days after posting');
    }
}
