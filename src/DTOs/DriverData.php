<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * Driver data DTO for Wasl API.
 *
 * Validation Rules:
 * - Driver Identity: Must be exactly 10 digits (Saudi National ID or Iqama)
 * - Email Address: Must be a valid email format
 * - Mobile Number: Must be in format +966XXXXXXXXX (Saudi phone number)
 * - Date of Birth: Either Hijri format YYYY-MM-DD or YYYY/MM/DD (Saudi) OR Gregorian format YYYY-MM-DD (Non-Saudi)
 *   - Only one date format must be provided (not both)
 *   - Saudi drivers must use Hijri date
 *   - Non-Saudi drivers must use Gregorian date
 */
final readonly class DriverData
{
    /**
     * @param string $identityNumber Driver identity number (10 digits)
     * @param string $emailAddress Driver email address
     * @param string $mobileNumber Mobile number in format +966XXXXXXXXX
     * @param string|null $dateOfBirthHijri Date of birth in Hijri format (YYYY-MM-DD or YYYY/MM/DD) for Saudi drivers
     * @param string|null $dateOfBirthGregorian Date of birth in Gregorian format (YYYY-MM-DD) for Non-Saudi drivers
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public string $identityNumber,
        public string $emailAddress,
        public string $mobileNumber,
        public ?string $dateOfBirthHijri = null,
        public ?string $dateOfBirthGregorian = null,
    ) {
        // Validate identity number: exactly 10 digits
        if (! preg_match('/^\d{10}$/', $this->identityNumber)) {
            throw new \InvalidArgumentException('Driver identity number must be exactly 10 digits');
        }

        // Validate email format
        if (! filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email address must be a valid email format');
        }

        // Validate mobile number format: +966XXXXXXXXX
        if (! preg_match('/^\+966\d{9}$/', $this->mobileNumber)) {
            throw new \InvalidArgumentException('Mobile number must be in format +966XXXXXXXXX');
        }

        // Validate date of birth: either Hijri or Gregorian, but not both
        if ($this->dateOfBirthHijri === null && $this->dateOfBirthGregorian === null) {
            throw new \InvalidArgumentException('Either dateOfBirthHijri or dateOfBirthGregorian must be provided');
        }

        if ($this->dateOfBirthHijri !== null && $this->dateOfBirthGregorian !== null) {
            throw new \InvalidArgumentException('Only one of dateOfBirthHijri or dateOfBirthGregorian should be provided');
        }

        // Validate Hijri date format: YYYY-MM-DD or YYYY/MM/DD
        if ($this->dateOfBirthHijri !== null) {
            if (! preg_match('/^\d{4}[-\/]\d{2}[-\/]\d{2}$/', $this->dateOfBirthHijri)) {
                throw new \InvalidArgumentException('Hijri date must be in format YYYY-MM-DD or YYYY/MM/DD');
            }
        }

        // Validate Gregorian date format: YYYY-MM-DD
        if ($this->dateOfBirthGregorian !== null) {
            if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->dateOfBirthGregorian)) {
                throw new \InvalidArgumentException('Gregorian date must be in format YYYY-MM-DD');
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'identityNumber' => $this->identityNumber,
            'emailAddress' => $this->emailAddress,
            'mobileNumber' => $this->mobileNumber,
        ];

        if ($this->dateOfBirthHijri !== null) {
            $data['dateOfBirthHijri'] = $this->dateOfBirthHijri;
        }

        if ($this->dateOfBirthGregorian !== null) {
            $data['dateOfBirthGregorian'] = $this->dateOfBirthGregorian;
        }

        return $data;
    }
}

