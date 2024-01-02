<?php

declare(strict_types=1);

namespace App\Exceptions\Article;

use DomainException;

class ArticleModerated extends DomainException
{
    public function __construct()
    {
        parent::__construct('Article already in moderation');
    }
}
