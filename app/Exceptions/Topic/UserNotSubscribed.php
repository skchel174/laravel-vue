<?php

declare(strict_types=1);

namespace App\Exceptions\Topic;

use DomainException;

class UserNotSubscribed extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('topic.not_subscribed'));
    }
}
