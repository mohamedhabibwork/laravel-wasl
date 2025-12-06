<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\DTOs;

use Habib\LaravelWasl\Rules\WaslPlateLetter;

/**
 * Vehicle data DTO for Wasl API.
 *
 * Validation Rules:
 * - Vehicle Sequence Number: Must be exactly 9 digits
 * - Plate Letters (Right, Middle, Left): Must be one of the allowed Arabic letters
 *   (ا، ب، ح، د، ر، س، ص، ط، ع، ق، ك، ل، م، ن، هـ، و، ى)
 * - Plate Number: Must be 1-4 digits
 * - Plate Type: Must be an integer between 1-11
 */
final readonly class VehicleData
{
    /**
     * @param  string  $sequenceNumber  Vehicle sequence number (9 digits)
     * @param  string  $plateLetterRight  Right plate letter (valid Arabic letter)
     * @param  string  $plateLetterMiddle  Middle plate letter (valid Arabic letter)
     * @param  string  $plateLetterLeft  Left plate letter (valid Arabic letter)
     * @param  string  $plateNumber  Plate number (1-4 digits)
     * @param  string  $plateType  Plate type (integer 1-11)
     *
     * @throws \InvalidArgumentException If validation fails
     */
    public function __construct(
        public string $sequenceNumber,
        public string $plateLetterRight,
        public string $plateLetterMiddle,
        public string $plateLetterLeft,
        public string $plateNumber,
        public string $plateType,
    ) {
        // Validate sequence number: exactly 9 digits
        if (! preg_match('/^\d{9}$/', $this->sequenceNumber)) {
            throw new \InvalidArgumentException('Vehicle sequence number must be exactly 9 digits');
        }

        // Validate plate letters: must be one of the allowed Arabic letters
        $allowedLetters = WaslPlateLetter::ALLOWED_LETTERS;
        if (! in_array($this->plateLetterRight, $allowedLetters, true)) {
            $allowedLettersStr = implode('، ', $allowedLetters);
            throw new \InvalidArgumentException("Plate letter right must be one of the allowed Arabic letters: {$allowedLettersStr}");
        }

        if (! in_array($this->plateLetterMiddle, $allowedLetters, true)) {
            $allowedLettersStr = implode('، ', $allowedLetters);
            throw new \InvalidArgumentException("Plate letter middle must be one of the allowed Arabic letters: {$allowedLettersStr}");
        }

        if (! in_array($this->plateLetterLeft, $allowedLetters, true)) {
            $allowedLettersStr = implode('، ', $allowedLetters);
            throw new \InvalidArgumentException("Plate letter left must be one of the allowed Arabic letters: {$allowedLettersStr}");
        }

        // Validate plate number: 1-4 digits
        if (! preg_match('/^\d{1,4}$/', $this->plateNumber)) {
            throw new \InvalidArgumentException('Plate number must be 1-4 digits');
        }

        // Validate plate type: integer 1-11
        $plateTypeInt = (int) $this->plateType;
        if ($plateTypeInt < 1 || $plateTypeInt > 11) {
            throw new \InvalidArgumentException('Plate type must be an integer between 1 and 11');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'sequenceNumber' => $this->sequenceNumber,
            'plateLetterRight' => $this->plateLetterRight,
            'plateLetterMiddle' => $this->plateLetterMiddle,
            'plateLetterLeft' => $this->plateLetterLeft,
            'plateNumber' => $this->plateNumber,
            'plateType' => $this->plateType,
        ];
    }
}
