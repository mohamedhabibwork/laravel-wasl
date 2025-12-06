<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

use Habib\LaravelWasl\Enums\EligibilityStatus;
use Habib\LaravelWasl\Enums\Gender;

final readonly class DriverRegistrationResponse
{
    /**
     * @param array<string>|null $rejectionReasons
     */
    public function __construct(
        public EligibilityStatus $eligibility,
        public ?string $eligibilityExpiryDate = null,
        public ?string $vehicleLicenseExpiryDate = null,
        public ?string $driverFullNameArabic = null,
        public ?string $driverFullNameEnglish = null,
        public ?Gender $driverGender = null,
        public ?array $rejectionReasons = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            eligibility: EligibilityStatus::from($data['eligibility']),
            eligibilityExpiryDate: $data['eligibilityExpiryDate'] ?? null,
            vehicleLicenseExpiryDate: $data['vehicleLicenseExpiryDate'] ?? null,
            driverFullNameArabic: $data['driverFullNameArabic'] ?? null,
            driverFullNameEnglish: $data['driverFullNameEnglish'] ?? null,
            driverGender: isset($data['driverGender']) ? Gender::from($data['driverGender']) : null,
            rejectionReasons: $data['rejectionReasons'] ?? null,
        );
    }
}

