<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Enums;

enum EligibilityStatus: string
{
    case VALID = 'VALID';
    case INVALID = 'INVALID';
    case PENDING = 'PENDING';
}

