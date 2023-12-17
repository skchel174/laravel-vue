<?php

declare(strict_types=1);

namespace App\Models\User\Exceptions;

use DomainException;

class ArticleNotBookmarked extends DomainException
{
    public function __construct()
    {
        parent::__construct('The article is not bookmarked');
    }
}
