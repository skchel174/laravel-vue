<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use DomainException;

class ArticlePublished extends DomainException
{
    public function __construct()
    {
        parent::__construct('Article already published');
    }
}
