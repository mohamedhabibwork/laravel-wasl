<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

final readonly class TripRegistrationResponse
{
    public function __construct(
        public bool $success,
        public string $resultCode,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['success'] ?? false),
            resultCode: $data['resultCode'] ?? 'unknown',
        );
    }
}
