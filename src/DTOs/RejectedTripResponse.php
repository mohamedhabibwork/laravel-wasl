<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

final readonly class RejectedTripResponse
{
    public function __construct(
        public string $tripId,
        public string $rejectionReason,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            tripId: $data['tripId'],
            rejectionReason: $data['rejectionReason'],
        );
    }
}

