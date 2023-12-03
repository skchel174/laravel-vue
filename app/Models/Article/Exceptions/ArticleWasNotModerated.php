<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use DomainException;

class ArticleWasNotModerated extends DomainException
{
    public function __construct()
    {
        parent::__construct('Article was not moderated');
    }
}
