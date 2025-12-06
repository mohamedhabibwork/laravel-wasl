<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Exceptions;

use Exception;

class WaslException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null,
        public readonly ?string $resultCode = null,
        public readonly ?string $resultMsg = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
