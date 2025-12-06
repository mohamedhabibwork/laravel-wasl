<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * Location update request DTO for Wasl API.
 *
 * Validation Rules:
 * - Maximum Locations: 1000 per request (when using bulk update)
 * - Update Frequency: Every 30 seconds (recommended)
 * - Driver & Vehicle: Must be registered in Wasl
 * - Has Customer: Boolean (true/false)
 * - Coordinates: Valid latitude (-90 to 90) and longitude (-180 to 180)
 * - Timestamp: ISO 8601 format YYYY-MM-DDTHH:mm:ss.SSS (KSA timezone)
 */
final readonly class LocationUpdateRequest
{
    /**
     * @param string $driverIdentityNumber Driver identity number (10 digits)
     * @param string $vehicleSequenceNumber Vehicle sequence number (9 digits)
     * @param float $latitude Latitude (-90 to 90)
     * @param float $longitude Longitude (-180 to 180)
     * @param bool $hasCustomer Whether vehicle has a customer (true/false)
     * @param string $updatedWhen Update timestamp in ISO 8601 format (KSA timezone)
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public string $driverIdentityNumber,
        public string $vehicleSequenceNumber,
        public float $latitude,
        public float $longitude,
        public bool $hasCustomer,
        public string $updatedWhen,
    ) {
        if ($this->latitude < -90 || $this->latitude > 90) {
            throw new \InvalidArgumentException('latitude must be between -90 and 90');
        }

        if ($this->longitude < -180 || $this->longitude > 180) {
            throw new \InvalidArgumentException('longitude must be between -180 and 180');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'driverIdentityNumber' => $this->driverIdentityNumber,
            'vehicleSequenceNumber' => $this->vehicleSequenceNumber,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'hasCustomer' => $this->hasCustomer,
            'updatedWhen' => $this->updatedWhen,
        ];
    }

    /**
     * @param array<LocationUpdateRequest> $locations
     * @return array<string, mixed>
     */
    public static function toBulkArray(array $locations): array
    {
        if (count($locations) > 1000) {
            throw new \InvalidArgumentException('Maximum 1000 locations allowed per request');
        }

        return [
            'locations' => array_map(
                fn (LocationUpdateRequest $location) => $location->toArray(),
                $locations
            ),
        ];
    }
}

