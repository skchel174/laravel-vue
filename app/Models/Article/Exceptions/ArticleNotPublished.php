<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use DomainException;

class ArticleNotPublished extends DomainException
{
    public function __construct()
    {
        parent::__construct('The article not published');
    }
}
