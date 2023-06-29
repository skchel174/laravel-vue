<?php

namespace App\Exceptions\HttpException;

interface HttpExceptionInterface
{
    /**
     * Http response code
     *
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * Headers to be sent along with the http response headers
     *
     * @return array
     */
    public function getHeaders(): array;
}
