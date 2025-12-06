<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Exceptions;

class WaslNotFoundException extends WaslException
{
    public function __construct(
        string $message = 'Resource not found',
        int $code = 404,
        ?\Throwable $previous = null,
        ?string $resultCode = null,
        ?string $resultMsg = null,
    ) {
        parent::__construct($message, $code, $previous, $resultCode, $resultMsg);
    }
}

