<?php

declare(strict_types=1);

namespace App\Exceptions\Article;

use DomainException;

class ArticleAlreadyLiked extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('article.already_liked'));
    }
}
