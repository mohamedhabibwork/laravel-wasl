<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Exceptions;

class WaslBadRequestException extends WaslException
{
    public function __construct(
        string $message = 'Bad request',
        int $code = 400,
        ?\Throwable $previous = null,
        ?string $resultCode = null,
        ?string $resultMsg = null,
    ) {
        parent::__construct($message, $code, $previous, $resultCode, $resultMsg);
    }
}

