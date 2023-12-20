<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use DomainException;

class ArticleNotLiked extends DomainException
{
    public function __construct()
    {
        parent::__construct('The article was not liked by the user');
    }
}
