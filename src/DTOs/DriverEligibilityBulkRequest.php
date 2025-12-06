<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

/**
 * Bulk driver eligibility inquiry request DTO for Wasl API.
 *
 * Validation Rules:
 * - Maximum Driver IDs: 10,000 per request
 * - Driver ID Format: Must be 10 digits (Saudi National ID or Iqama)
 * - Must be checked: Every 24 hours minimum
 */
final readonly class DriverEligibilityBulkRequest
{
    /**
     * @param array<string> $driverIds Array of driver identity numbers (10 digits each)
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public array $driverIds,
    ) {
        if (count($this->driverIds) > 10000) {
            throw new \InvalidArgumentException('Maximum 10,000 driver IDs allowed per request');
        }

        if (empty($this->driverIds)) {
            throw new \InvalidArgumentException('At least one driver ID is required');
        }

        // Validate each driver ID is exactly 10 digits
        foreach ($this->driverIds as $driverId) {
            if (! preg_match('/^\d{10}$/', $driverId)) {
                throw new \InvalidArgumentException("Driver ID '{$driverId}' must be exactly 10 digits");
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'driverIds' => array_map(
                fn (string $id) => ['id' => $id],
                $this->driverIds
            ),
        ];
    }
}

