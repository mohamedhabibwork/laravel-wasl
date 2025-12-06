<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validation rule for Wasl API plate letters.
 *
 * Validates that a plate letter is one of the allowed Arabic letters:
 * ا، ب، ح، د، ر، س، ص، ط، ع، ق، ك، ل، م، ن، هـ، و، ى
 */
final class WaslPlateLetter implements ValidationRule
{
    /**
     * Allowed Arabic letters for Saudi vehicle plates
     *
     * @var array<string>
     */
    public const ALLOWED_LETTERS = [
        'ا',
        'ب',
        'ح',
        'د',
        'ر',
        'س',
        'ص',
        'ط',
        'ع',
        'ق',
        'ك',
        'ل',
        'م',
        'ن',
        'هـ',
        'و',
        'ى',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, string=): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('The :attribute must be a string.');

            return;
        }

        if (! in_array($value, self::ALLOWED_LETTERS, true)) {
            $allowedLetters = implode('، ', self::ALLOWED_LETTERS);
            $fail("The :attribute must be one of the allowed Arabic letters: {$allowedLetters}");
        }
    }
}
