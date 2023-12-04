<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use App\Models\Tag\Tag;
use DomainException;

class ArticleHasTag extends DomainException
{
    public function __construct(Tag $tag)
    {
        parent::__construct(sprintf('Article already has a tag "%s"', $tag->name));
    }
}
