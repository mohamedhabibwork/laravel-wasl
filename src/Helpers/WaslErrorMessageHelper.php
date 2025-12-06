<?php

declare(strict_types=1);

namespace Habib\LaravelWasl\Helpers;

/**
 * Helper class for Wasl API error messages and descriptions.
 *
 * Provides centralized access to error code meanings, rejection reasons,
 * and status descriptions from the Wasl API documentation.
 */
final class WaslErrorMessageHelper
{
    /**
     * Get description for a result code.
     *
     * @return array<string, string>|null
     */
    public static function getResultCodeDescription(string $code): ?string
    {
        return self::getResultCodes()[$code] ?? null;
    }

    /**
     * Get description for a rejection reason.
     */
    public static function getRejectionReasonDescription(string $reason): ?string
    {
        return self::getRejectionReasons()[$reason] ?? null;
    }

    /**
     * Get description for a criminal record status.
     */
    public static function getCriminalRecordStatusDescription(string $status): ?string
    {
        return self::getCriminalRecordStatuses()[$status] ?? null;
    }

    /**
     * Get trip rejection reason description.
     *
     * @param bool $arabic If true, returns Arabic description
     */
    public static function getTripRejectionReason(string $reason, bool $arabic = false): ?string
    {
        $reasons = self::getTripRejectionReasons();

        if ($arabic) {
            return $reasons[$reason]['arabic'] ?? null;
        }

        return $reasons[$reason]['english'] ?? null;
    }

    /**
     * Get all result codes with descriptions.
     *
     * @return array<string, string>
     */
    public static function getResultCodes(): array
    {
        return [
            'success' => 'Technical Success',
            'bad_request' => 'Defined in resultMsg',
            'DRIVER_VEHICLE_DUPLICATE' => 'Driver or vehicle already registered',
            'DRIVER_NOT_ALLOWED' => 'Foreign nationalities are not allowed per TGA rules',
            'DRIVER_NOT_FOUND' => 'Driver information is not correct',
            'VEHICLE_NOT_FOUND' => 'Vehicle information is not correct',
            'VEHICLE_NOT_OWNED_BY_FINANCIER' => 'Vehicle ownership not associated with driver or SAMA approved financer',
            'DRIVER_NOT_AUTHORIZED_TO_DRIVE_VEHICLE' => 'Driver does not own vehicle and no legal association',
            'NO_VALID_OPERATION_CARD' => 'No valid operating card found',
        ];
    }

    /**
     * Get all rejection reasons with descriptions.
     *
     * @return array<string, string>
     */
    public static function getRejectionReasons(): array
    {
        return [
            'ALIEN_LEGAL_STATUS_NOT_VALID' => 'Alien residency is not valid',
            'MAX_AGE_NOT_SATISFIED' => "Driver's age is greater than 65",
            'MIN_AGE_NOT_SATISFIED' => 'Driver age is less than 18',
            'DRIVER_IDENTITY_EXPIRED' => "Driver's identity is expired",
            'DRIVER_IS_BANNED' => 'Driver is banned from dispatching activities',
            'DRIVER_LICENSE_EXPIRED' => 'Driver license is expired',
            'DRIVER_LICENSE_NOT_ALLOWED' => "Driver's license type is not allowed",
            'VEHICLE_INSURANCE_EXPIRED' => "Vehicle's insurance has expired",
            'VEHICLE_LICENSE_EXPIRED' => "Vehicle's license has expired",
            'VEHICLE_NOT_INSURED' => 'Vehicle does not have valid insurance',
            'OLD_VEHICLE_MODEL' => "Vehicle's model is older than 5 years",
            'PERIODIC_INSPECTION_POLICY_EXPIRED' => "Vehicle's periodic inspection expired",
            'DRIVER_FAILED_CRIMINAL_RECORD_CHECK' => 'Driver failed criminal record check',
            'DRIVER_REJECTED_CRIMINAL_RECORD_CHECK' => 'Driver declined criminal record check',
            'CRIMINAL_RECORD_CHECK_PERIOD_EXPIRED' => 'Driver did not respond within 10 days',
            'VEHICLE_PLATE_TYPE_NOT_ALLOWED' => 'Vehicle plate type is not allowed',
            'OPERATION_CARD_EXPIRED' => 'Vehicle operation card is expired',
            'DRIVER_ELIGIBILITY_EXPIRED' => 'Driver eligibility status is expired',
            'DRIVER_VEHICLE_INELIGIBLE' => 'Driver does not have an eligible vehicle',
            'VEHICLE_ELIGIBILITY_EXPIRED' => 'Vehicle eligibility expired',
            'NO_VALID_OPERATION_CARD_FOUND' => 'Vehicle does not have a valid operation card',
            'DRIVER_REJECTED_MANY_CRIMINAL_RECORD_CHECK' => 'Driver rejected or didn\'t respond to 3+ criminal checks',
        ];
    }

    /**
     * Get all criminal record statuses with descriptions.
     *
     * @return array<string, string>
     */
    public static function getCriminalRecordStatuses(): array
    {
        return [
            'WAITING' => 'Waiting for sending criminal record check request',
            'PENDING_DRIVER_APPROVAL' => 'SMS sent to driver, waiting for approval on Absher',
            'DRIVER_APPROVED' => 'Criminal record check approved by driver',
            'DRIVER_REJECTED' => 'Criminal record check declined by driver',
            'UNDER_PROCESSING' => 'Driver is undergoing criminal record checks',
            'DONE_RESULT_OK' => 'No criminal record, driver can practice activity',
            'DONE_RESULT_NOT_OK' => 'Criminal record found, driver is ineligible',
            'REQUEST_EXPIRED' => 'Driver did not respond within 10 days',
        ];
    }

    /**
     * Get all trip rejection reasons with English and Arabic descriptions.
     *
     * @return array<string, array{english: string, arabic: string}>
     */
    public static function getTripRejectionReasons(): array
    {
        return [
            'sequence number must not be blank' => [
                'english' => 'Vehicle sequence number must not be blank',
                'arabic' => 'لم يتم إرسال الرقم التسلسلي للمركبة',
            ],
            'invalid sequence number' => [
                'english' => 'Vehicle sequence number is invalid',
                'arabic' => 'الرقم التسلسلي للمركبة غير صالح',
            ],
            'vehicle not found' => [
                'english' => 'Vehicle is not registered in Wasl',
                'arabic' => 'المركبة غير مسجلة في وصل',
            ],
            'driver id must not be null' => [
                'english' => 'Driver identity number must not be null',
                'arabic' => 'لم يتم إرسال رقم هوية السائق',
            ],
            'invalid driver id' => [
                'english' => 'Driver identity number is invalid',
                'arabic' => 'رقم هوية السائق غير صالح',
            ],
            'driver not found' => [
                'english' => 'Driver is not registered in Wasl',
                'arabic' => 'السائق غير مسجل في وصل',
            ],
            'trip id must not be null' => [
                'english' => 'Trip ID must not be null',
                'arabic' => 'لم يتم إرسال رقم الرحلة',
            ],
            'duplicate trip id' => [
                'english' => 'Trip ID is already registered',
                'arabic' => 'رقم الرحلة مسجل مسبقا',
            ],
            'overlap vehicle driver time app' => [
                'english' => 'Time overlap with another trip for the same driver and vehicle',
                'arabic' => 'تداخل زمني مع رحلة أخرى لنفس السائق والمركبة',
            ],
            'started when must not be null' => [
                'english' => 'Trip start time must not be null',
                'arabic' => 'لم يتم إرسال وقت بداية الرحلة',
            ],
            'pickup timestamp must be a past date' => [
                'english' => 'Customer pickup time must be a past date',
                'arabic' => 'وقت ركوب العميل يجب أن يكون تاريخا ماضيا',
            ],
            'dropoff timestamp must be a past date' => [
                'english' => 'Customer dropoff time must be a past date',
                'arabic' => 'وقت نزول العميل يجب أن يكون تاريخا ماضيا',
            ],
            'distance in meters must not be null' => [
                'english' => 'Distance traveled must not be null',
                'arabic' => 'لم يتم إرسال المسافة المقطوعة',
            ],
            'customer rating must be between 0 and 5' => [
                'english' => 'Customer rating for the trip is out of range from 0 to 5',
                'arabic' => 'تقييم العميل للرحلة خارج النطاق من 0 إلى 5',
            ],
            'origin location out of saudi arabia' => [
                'english' => 'Origin location is outside Saudi Arabia',
                'arabic' => 'موقع الانطلاق خارج السعودية',
            ],
            'destination location out of saudi arabia' => [
                'english' => 'Destination location is outside Saudi Arabia',
                'arabic' => 'موقع الوصول خارج السعودية',
            ],
            'vehicle is not eligible in Wasl' => [
                'english' => 'Vehicle is not eligible in Wasl',
                'arabic' => 'المركبة غير مؤهلة في وصل',
            ],
        ];
    }
}

