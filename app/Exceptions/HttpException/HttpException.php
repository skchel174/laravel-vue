<?php

declare(strict_types=1);

namespace App\Exceptions\HttpException;

use Exception;
use Throwable;

class HttpException extends Exception implements HttpExceptionInterface
{
    public function __construct(
        private readonly int $httpCode,
        string $message = "",
        private readonly array $headers = [],
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
