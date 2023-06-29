<?php

declare(strict_types=1);

namespace App\Models\Post\Exceptions;

use App\Exceptions\HttpException\HttpException;
use App\Models\Post\Post;

class PostAlreadyPublishedException extends HttpException
{
    public function __construct(Post $post)
    {
        $message = sprintf('Post "%s" already published.', $post->title->getValue());

        parent::__construct(422, $message);
    }
}
