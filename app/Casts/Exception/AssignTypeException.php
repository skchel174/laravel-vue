<?php

declare(strict_types=1);

namespace App\Casts\Exception;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class AssignTypeException extends RuntimeException
{
    public function __construct(Model $model, string $property, mixed $value)
    {
        $message = sprintf(
            'Cannot assign "%s" to property %s::%s of type %s',
            gettype($value),
            $model::class,
            $property,
            static::class
        );

        parent::__construct($message);
    }
}
