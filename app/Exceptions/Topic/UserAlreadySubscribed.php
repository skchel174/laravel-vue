<?php

declare(strict_types=1);

namespace App\Exceptions\Topic;

use DomainException;

class UserAlreadySubscribed extends DomainException
{
    public function __construct()
    {
        parent::__construct(trans('topic.already_subscribed'));
    }
}
