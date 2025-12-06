<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * Trip registration request DTO for Wasl API.
 *
 * Validation Rules:
 * - Trip ID: Must be unique, String format
 * - Distance: Minimum 1 meter
 * - Duration: Minimum 1 second
 * - Customer Rating: 0-5 (0 for unrated trips)
 * - Timestamps: ISO 8601 format YYYY-MM-DDTHH:mm:ss.SSS (KSA timezone)
 * - Coordinates: Latitude (-90 to 90), Longitude (-180 to 180)
 * - Trip Cost: Mandatory, Double (Saudi Riyals)
 * - Driver & Vehicle: Must be registered and eligible in Wasl
 */
final readonly class TripRegistrationRequest
{
    /**
     * @param string $sequenceNumber Vehicle sequence number
     * @param string $driverId Driver identity number (10 digits)
     * @param string $tripId Unique trip identifier (string format)
     * @param int $distanceInMeters Distance traveled in meters (minimum 1)
     * @param int $durationInSeconds Trip duration in seconds (minimum 1)
     * @param float $customerRating Customer rating (0-5, 0 for unrated trips)
     * @param int|null $customerWaitingTimeInSeconds Customer waiting time in seconds
     * @param string|null $originCityNameInArabic Origin city name in Arabic
     * @param string|null $destinationCityNameInArabic Destination city name in Arabic
     * @param float $originLatitude Origin latitude (-90 to 90)
     * @param float $originLongitude Origin longitude (-180 to 180)
     * @param float $destinationLatitude Destination latitude (-90 to 90)
     * @param float $destinationLongitude Destination longitude (-180 to 180)
     * @param string $pickupTimestamp Pickup timestamp in ISO 8601 format (KSA timezone)
     * @param string $dropoffTimestamp Dropoff timestamp in ISO 8601 format (KSA timezone)
     * @param string $startedWhen Trip start timestamp in ISO 8601 format (KSA timezone)
     * @param float $tripCost Trip cost in Saudi Riyals (mandatory)
     * @param string|null $driverArrivalTime Driver arrival time in ISO 8601 format (KSA timezone)
     * @param string|null $driverAssignTime Driver assignment time in ISO 8601 format (KSA timezone)
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public string $sequenceNumber,
        public string $driverId,
        public string $tripId,
        public int $distanceInMeters,
        public int $durationInSeconds,
        public float $customerRating,
        public ?int $customerWaitingTimeInSeconds = null,
        public ?string $originCityNameInArabic = null,
        public ?string $destinationCityNameInArabic = null,
        public float $originLatitude,
        public float $originLongitude,
        public float $destinationLatitude,
        public float $destinationLongitude,
        public string $pickupTimestamp,
        public string $dropoffTimestamp,
        public string $startedWhen,
        public float $tripCost,
        public ?string $driverArrivalTime = null,
        public ?string $driverAssignTime = null,
    ) {
        if ($this->distanceInMeters < 1) {
            throw new \InvalidArgumentException('distanceInMeters must be at least 1');
        }

        if ($this->durationInSeconds < 1) {
            throw new \InvalidArgumentException('durationInSeconds must be at least 1');
        }

        if ($this->customerRating < 0 || $this->customerRating > 5) {
            throw new \InvalidArgumentException('customerRating must be between 0 and 5');
        }

        if ($this->originLatitude < -90 || $this->originLatitude > 90) {
            throw new \InvalidArgumentException('originLatitude must be between -90 and 90');
        }

        if ($this->originLongitude < -180 || $this->originLongitude > 180) {
            throw new \InvalidArgumentException('originLongitude must be between -180 and 180');
        }

        if ($this->destinationLatitude < -90 || $this->destinationLatitude > 90) {
            throw new \InvalidArgumentException('destinationLatitude must be between -90 and 90');
        }

        if ($this->destinationLongitude < -180 || $this->destinationLongitude > 180) {
            throw new \InvalidArgumentException('destinationLongitude must be between -180 and 180');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'sequenceNumber' => $this->sequenceNumber,
            'driverId' => $this->driverId,
            'tripId' => $this->tripId,
            'distanceInMeters' => $this->distanceInMeters,
            'durationInSeconds' => $this->durationInSeconds,
            'customerRating' => $this->customerRating,
            'originLatitude' => $this->originLatitude,
            'originLongitude' => $this->originLongitude,
            'destinationLatitude' => $this->destinationLatitude,
            'destinationLongitude' => $this->destinationLongitude,
            'pickupTimestamp' => $this->pickupTimestamp,
            'dropoffTimestamp' => $this->dropoffTimestamp,
            'startedWhen' => $this->startedWhen,
            'tripCost' => $this->tripCost,
        ];

        if ($this->customerWaitingTimeInSeconds !== null) {
            $data['customerWaitingTimeInSeconds'] = $this->customerWaitingTimeInSeconds;
        }

        if ($this->originCityNameInArabic !== null) {
            $data['originCityNameInArabic'] = $this->originCityNameInArabic;
        }

        if ($this->destinationCityNameInArabic !== null) {
            $data['destinationCityNameInArabic'] = $this->destinationCityNameInArabic;
        }

        if ($this->driverArrivalTime !== null) {
            $data['driverArrivalTime'] = $this->driverArrivalTime;
        }

        if ($this->driverAssignTime !== null) {
            $data['driverAssignTime'] = $this->driverAssignTime;
        }

        return $data;
    }
}

