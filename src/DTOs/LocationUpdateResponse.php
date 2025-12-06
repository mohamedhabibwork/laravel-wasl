<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

final readonly class LocationUpdateResponse
{
    /**
     * @param array<string> $failedVehicles
     */
    public function __construct(
        public bool $success,
        public string $resultCode,
        public array $failedVehicles = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $failedVehicles = [];
        if (isset($data['result']['failedVehicles']) && is_array($data['result']['failedVehicles'])) {
            $failedVehicles = $data['result']['failedVehicles'];
        }

        return new self(
            success: (bool) ($data['success'] ?? false),
            resultCode: $data['resultCode'] ?? 'unknown',
            failedVehicles: $failedVehicles,
        );
    }
}

