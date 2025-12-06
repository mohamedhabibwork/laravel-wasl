<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

use Habib\LaravelWasl\Enums\CriminalRecordStatus;
use Habib\LaravelWasl\Enums\EligibilityStatus;

final readonly class DriverEligibilityResponse
{
    /**
     * @param array<VehicleEligibilityResponse> $vehicles
     * @param array<string>|null $rejectionReasons
     */
    public function __construct(
        public string $identityNumber,
        public EligibilityStatus $driverEligibility,
        public ?string $eligibilityExpiryDate = null,
        public ?string $driverRejectionReason = null,
        public ?array $rejectionReasons = null,
        public ?CriminalRecordStatus $criminalRecordStatus = null,
        public array $vehicles = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $vehicles = [];
        if (isset($data['vehicles']) && is_array($data['vehicles'])) {
            $vehicles = array_map(
                fn (array $vehicle) => VehicleEligibilityResponse::fromArray($vehicle),
                $data['vehicles']
            );
        }

        $rejectionReasons = null;
        if (isset($data['driverRejectionReason'])) {
            $rejectionReasons = [$data['driverRejectionReason']];
        } elseif (isset($data['rejectionReasons']) && is_array($data['rejectionReasons'])) {
            $rejectionReasons = $data['rejectionReasons'];
        }

        return new self(
            identityNumber: $data['identityNumber'],
            driverEligibility: EligibilityStatus::from($data['driverEligibility']),
            eligibilityExpiryDate: $data['eligibilityExpiryDate'] ?? null,
            driverRejectionReason: $data['driverRejectionReason'] ?? null,
            rejectionReasons: $rejectionReasons,
            criminalRecordStatus: isset($data['criminalRecordStatus']) ? CriminalRecordStatus::from($data['criminalRecordStatus']) : null,
            vehicles: $vehicles,
        );
    }
}

