<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Exceptions;

class WaslServerException extends WaslException
{
    public function __construct(
        string $message = 'Server error',
        int $code = 500,
        ?\Throwable $previous = null,
        ?string $resultCode = null,
        ?string $resultMsg = null,
    ) {
        parent::__construct($message, $code, $previous, $resultCode, $resultMsg);
    }
}
