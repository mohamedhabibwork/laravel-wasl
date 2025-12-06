<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Enums;

enum PlateType: string
{
    case PRIVATE_CAR = 'PRIVATE_CAR';
    case TAXI = 'TAXI';
    case TRUCK = 'TRUCK';
    case BUS = 'BUS';
    case MOTORCYCLE = 'MOTORCYCLE';

    public static function fromInt(int $value): self
    {
        return match ($value) {
            1 => self::PRIVATE_CAR,
            2 => self::TAXI,
            3 => self::TRUCK,
            4 => self::BUS,
            5 => self::MOTORCYCLE,
            default => self::PRIVATE_CAR,
        };
    }

    public function toInt(): int
    {
        return match ($this) {
            self::PRIVATE_CAR => 1,
            self::TAXI => 2,
            self::TRUCK => 3,
            self::BUS => 4,
            self::MOTORCYCLE => 5,
        };
    }
}

