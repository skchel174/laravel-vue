<?php

declare(strict_types=1);

namespace App\Exceptions\Article;

use DomainException;

class ArticleNotDeleted extends DomainException
{
    public function __construct()
    {
        parent::__construct('Article not deleted');
    }
}
