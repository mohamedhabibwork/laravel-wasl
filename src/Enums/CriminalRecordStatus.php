<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Enums;

enum CriminalRecordStatus: string
{
    case WAITING = 'WAITING';
    case PENDING_DRIVER_APPROVAL = 'PENDING_DRIVER_APPROVAL';
    case DRIVER_APPROVED = 'DRIVER_APPROVED';
    case DRIVER_REJECTED = 'DRIVER_REJECTED';
    case UNDER_PROCESSING = 'UNDER_PROCESSING';
    case DONE_RESULT_OK = 'DONE_RESULT_OK';
    case DONE_RESULT_NOT_OK = 'DONE_RESULT_NOT_OK';
    case REQUEST_EXPIRED = 'REQUEST_EXPIRED';
}
