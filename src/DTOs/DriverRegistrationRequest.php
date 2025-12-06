<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

final readonly class DriverRegistrationRequest
{
    public function __construct(
        public DriverData $driver,
        public VehicleData $vehicle,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'driver' => $this->driver->toArray(),
            'vehicle' => $this->vehicle->toArray(),
        ];
    }
}

