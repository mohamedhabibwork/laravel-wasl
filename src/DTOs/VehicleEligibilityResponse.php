<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

use Habib\LaravelWasl\Enums\EligibilityStatus;

final readonly class VehicleEligibilityResponse
{
    /**
     * @param  array<string>|null  $rejectionReasons
     */
    public function __construct(
        public string $sequenceNumber,
        public ?string $vehiclePlate = null,
        public ?string $plateType = null,
        public ?EligibilityStatus $vehicleEligibility = null,
        public ?string $eligibilityExpiryDate = null,
        public ?string $vehicleLicenseExpiryDate = null,
        public ?array $rejectionReasons = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $rejectionReasons = null;
        if (isset($data['vehicleRejectionReason'])) {
            $rejectionReasons = [$data['vehicleRejectionReason']];
        } elseif (isset($data['rejectionReasons']) && is_array($data['rejectionReasons'])) {
            $rejectionReasons = $data['rejectionReasons'];
        }

        return new self(
            sequenceNumber: $data['sequenceNumber'],
            vehiclePlate: $data['vehiclePlate'] ?? null,
            plateType: $data['plateType'] ?? null,
            vehicleEligibility: isset($data['vehicleEligibility']) ? EligibilityStatus::from($data['vehicleEligibility']) : null,
            eligibilityExpiryDate: $data['eligibilityExpiryDate'] ?? null,
            vehicleLicenseExpiryDate: $data['vehicleLicenseExpiryDate'] ?? null,
            rejectionReasons: $rejectionReasons,
        );
    }
}
