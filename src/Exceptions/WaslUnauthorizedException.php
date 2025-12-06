<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Exceptions;

class WaslUnauthorizedException extends WaslException
{
    public function __construct(
        string $message = 'Unauthorized',
        int $code = 401,
        ?\Throwable $previous = null,
        ?string $resultCode = null,
        ?string $resultMsg = null,
    ) {
        parent::__construct($message, $code, $previous, $resultCode, $resultMsg);
    }
}

