<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * @param  array<DriverEligibilityResponse>  $responses
 */
final readonly class DriverEligibilityBulkResponse
{
    /**
     * @param  array<DriverEligibilityResponse>  $responses
     */
    public function __construct(
        public array $responses,
    ) {}

    /**
     * @param  array<array<string, mixed>>  $data
     */
    public static function fromArray(array $data): self
    {
        $responses = array_map(
            fn (array $item) => DriverEligibilityResponse::fromArray($item),
            $data
        );

        return new self(responses: $responses);
    }
}
