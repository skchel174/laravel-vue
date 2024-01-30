<?php

declare(strict_types=1);

namespace App\Exceptions\Comment;

use DomainException;

class CommentNotCommentable extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('comment.max_depth'));
    }
}
