<?php

declare(strict_types=1);

namespace App\Models\Comment\Exception;

use DomainException;

class CommentNotCommentable extends DomainException
{
    public function __construct()
    {
        parent::__construct('Maximum comment tree depth reached');
    }
}
