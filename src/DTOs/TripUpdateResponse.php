<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

final readonly class TripUpdateResponse
{
    /**
     * @param array<RejectedTripResponse> $rejectedTrips
     */
    public function __construct(
        public bool $success,
        public string $resultCode,
        public array $rejectedTrips = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $rejectedTrips = [];
        if (isset($data['result']['rejectedTrips']) && is_array($data['result']['rejectedTrips'])) {
            $rejectedTrips = array_map(
                fn (array $trip) => RejectedTripResponse::fromArray($trip),
                $data['result']['rejectedTrips']
            );
        }

        return new self(
            success: (bool) ($data['success'] ?? false),
            resultCode: $data['resultCode'] ?? 'unknown',
            rejectedTrips: $rejectedTrips,
        );
    }
}

