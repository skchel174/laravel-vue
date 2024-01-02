<?php

declare(strict_types=1);

namespace App\Exceptions\Comment;

use DomainException;

class NotBelongsToArticle extends DomainException
{
    public function __construct()
    {
        parent::__construct('Commentary does not belong to the article');
    }
}
