<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class ArticleAlreadyBookmarked extends DomainException
{
    public function __construct()
    {
        parent::__construct('The article has already been bookmarked');
    }
}
