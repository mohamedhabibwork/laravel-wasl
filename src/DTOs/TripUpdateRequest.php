<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * Trip update request DTO for Wasl API.
 *
 * Validation Rules:
 * - Maximum Trips: 1000 per request (when using bulk update)
 * - Trip ID: Must exist in Wasl
 * - Customer Rating: 0-5 (if provided)
 * - Coordinates: Valid latitude (-90 to 90) and longitude (-180 to 180) if provided
 * - Trip Cost: Mandatory if provided, Double (Saudi Riyals)
 */
final readonly class TripUpdateRequest
{
    /**
     * @param string $tripId Trip ID that must exist in Wasl
     * @param float|null $customerRating Customer rating (0-5) if provided
     * @param float|null $originLatitude Origin latitude (-90 to 90) if provided
     * @param float|null $originLongitude Origin longitude (-180 to 180) if provided
     * @param float|null $destinationLatitude Destination latitude (-90 to 90) if provided
     * @param float|null $destinationLongitude Destination longitude (-180 to 180) if provided
     * @param float|null $tripCost Trip cost in Saudi Riyals if provided
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public string $tripId,
        public ?float $customerRating = null,
        public ?float $originLatitude = null,
        public ?float $originLongitude = null,
        public ?float $destinationLatitude = null,
        public ?float $destinationLongitude = null,
        public ?float $tripCost = null,
    ) {
        if ($this->customerRating !== null && ($this->customerRating < 0 || $this->customerRating > 5)) {
            throw new \InvalidArgumentException('customerRating must be between 0 and 5');
        }

        if ($this->originLatitude !== null && ($this->originLatitude < -90 || $this->originLatitude > 90)) {
            throw new \InvalidArgumentException('originLatitude must be between -90 and 90');
        }

        if ($this->originLongitude !== null && ($this->originLongitude < -180 || $this->originLongitude > 180)) {
            throw new \InvalidArgumentException('originLongitude must be between -180 and 180');
        }

        if ($this->destinationLatitude !== null && ($this->destinationLatitude < -90 || $this->destinationLatitude > 90)) {
            throw new \InvalidArgumentException('destinationLatitude must be between -90 and 90');
        }

        if ($this->destinationLongitude !== null && ($this->destinationLongitude < -180 || $this->destinationLongitude > 180)) {
            throw new \InvalidArgumentException('destinationLongitude must be between -180 and 180');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = ['tripId' => $this->tripId];

        if ($this->customerRating !== null) {
            $data['customerRating'] = $this->customerRating;
        }

        if ($this->originLatitude !== null) {
            $data['originLatitude'] = $this->originLatitude;
        }

        if ($this->originLongitude !== null) {
            $data['originLongitude'] = $this->originLongitude;
        }

        if ($this->destinationLatitude !== null) {
            $data['destinationLatitude'] = $this->destinationLatitude;
        }

        if ($this->destinationLongitude !== null) {
            $data['destinationLongitude'] = $this->destinationLongitude;
        }

        if ($this->tripCost !== null) {
            $data['tripCost'] = $this->tripCost;
        }

        return $data;
    }

    /**
     * @param array<TripUpdateRequest> $trips
     * @return array<string, mixed>
     */
    public static function toBulkArray(array $trips): array
    {
        if (count($trips) > 1000) {
            throw new \InvalidArgumentException('Maximum 1000 trips allowed per request');
        }

        return [
            'trips' => array_map(
                fn (TripUpdateRequest $trip) => $trip->toArray(),
                $trips
            ),
        ];
    }
}

