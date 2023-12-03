<?php

declare(strict_types=1);

namespace App\Models\Article\Exceptions;

use App\Models\Topic\Topic;
use DomainException;

class TopicAlreadyAttached extends DomainException
{
    public function __construct(Topic $topic)
    {
        parent::__construct(sprintf('Topic "%s" already attached to the article', $topic->name));
    }
}
