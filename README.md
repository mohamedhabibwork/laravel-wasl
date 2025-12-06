# Laravel Wasl

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mohamedhabibwork/laravel-wasl.svg?style=flat-square)](https://packagist.org/packages/mohamedhabibwork/laravel-wasl)
<!-- [![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mohamedhabibwork/laravel-wasl/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mohamedhabibwork/laravel-wasl/actions?query=workflow%3Arun-tests+branch%3Amain) -->
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mohamedhabibwork/laravel-wasl/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mohamedhabibwork/laravel-wasl/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mohamedhabibwork/laravel-wasl.svg?style=flat-square)](https://packagist.org/packages/mohamedhabibwork/laravel-wasl)

A Laravel package for integrating with the Wasl API (Saudi Arabia's Transportation General Authority dispatching platform). This package provides a clean, type-safe interface for all Wasl API endpoints including driver registration, eligibility checks, trip management, and location tracking.

## Features

- ✅ Complete Wasl API integration
- ✅ Type-safe DTOs with strict typing (PHP 8.3+)
- ✅ Comprehensive error handling with custom exceptions
- ✅ Built-in validation rules (plate letters, identity numbers, etc.)
- ✅ Error message helper with all Wasl API error codes and descriptions
- ✅ Support for bulk operations (arrays)
- ✅ Clean, modern code following Laravel best practices
- ✅ Full support for all 6 Wasl API endpoints

## Requirements

- PHP 8.3 or higher
- Laravel 11.x or 12.x

## Installation

You can install the package via composer:

```bash
composer require mohamedhabibwork/laravel-wasl
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag="laravel-wasl-config"
```

Add your Wasl API credentials to your `.env` file:

**Environment-based configuration (Recommended):**

```env
# Set environment: 'live' or 'dev' (default: 'live')
WASL_ENV=live

# Live environment credentials
LIVE_WASL_BASE_URL=https://wasl.api.elm.sa/api/dispatching/v2
LIVE_WASL_CLIENT_ID=your_live_client_id
LIVE_WASL_APP_ID=your_live_app_id
LIVE_WASL_APP_KEY=your_live_app_key
LIVE_WASL_TIMEOUT=30

# Dev environment credentials
DEV_WASL_BASE_URL=https://wasl.api.elm.sa/api/dispatching/v2
DEV_WASL_CLIENT_ID=your_dev_client_id
DEV_WASL_APP_ID=your_dev_app_id
DEV_WASL_APP_KEY=your_dev_app_key
DEV_WASL_TIMEOUT=30
```

### Environment Configuration

The package supports two environments:

- **`live`** - Production environment (default)
- **`dev`** - Development/Testing environment

Set `WASL_ENV=dev` in your `.env` file to use the development environment. The package will automatically use the corresponding prefixed environment variables (`DEV_WASL_*` or `LIVE_WASL_*`).

## Usage

### Driver Registration

Register a driver and vehicle with Wasl:

```php
use Habib\LaravelWasl\Facades\LaravelWasl;
use Habib\LaravelWasl\DTOs\DriverRegistrationRequest;
use Habib\LaravelWasl\DTOs\DriverData;
use Habib\LaravelWasl\DTOs\VehicleData;

// For Saudi driver (Hijri date)
$driver = new DriverData(
    identityNumber: '1234567890',
    emailAddress: 'driver@example.com',
    mobileNumber: '+966512345678',
    dateOfBirthHijri: '1420/01/01'
);

// For Non-Saudi driver (Gregorian date)
$driver = new DriverData(
    identityNumber: '2234567890',
    emailAddress: 'driver@example.com',
    mobileNumber: '+966512345678',
    dateOfBirthGregorian: '1990-01-01'
);

$vehicle = new VehicleData(
    sequenceNumber: '123456879',
    plateLetterRight: 'ا',
    plateLetterMiddle: 'ا',
    plateLetterLeft: 'ا',
    plateNumber: '1234',
    plateType: '1'
);

$request = new DriverRegistrationRequest(
    driver: $driver,
    vehicle: $vehicle
);

$response = LaravelWasl::registerDriver($request);

// Check eligibility status
if ($response->eligibility === \Habib\LaravelWasl\Enums\EligibilityStatus::VALID) {
    echo "Driver is eligible until: " . $response->eligibilityExpiryDate;
}
```

### Check Driver Eligibility (Single)

```php
use Habib\LaravelWasl\Facades\LaravelWasl;

$response = LaravelWasl::checkEligibility('1234567890');

echo "Eligibility: " . $response->driverEligibility->value;
echo "Expiry Date: " . $response->eligibilityExpiryDate;

foreach ($response->vehicles as $vehicle) {
    echo "Vehicle: " . $vehicle->sequenceNumber;
    echo "Vehicle Eligibility: " . $vehicle->vehicleEligibility->value;
}
```

### Check Driver Eligibility (Bulk)

Check eligibility for multiple drivers at once (max 10,000):

```php
use Habib\LaravelWasl\Facades\LaravelWasl;
use Habib\LaravelWasl\DTOs\DriverEligibilityBulkRequest;

$request = new DriverEligibilityBulkRequest([
    '1000000001',
    '1000000002',
    '1000000003'
]);

$response = LaravelWasl::checkEligibilityBulk($request);

foreach ($response->responses as $driverResponse) {
    echo "Driver: " . $driverResponse->identityNumber;
    echo "Eligibility: " . $driverResponse->driverEligibility->value;
}
```

### Register a Trip

```php
use Habib\LaravelWasl\Facades\LaravelWasl;
use Habib\LaravelWasl\DTOs\TripRegistrationRequest;

$request = new TripRegistrationRequest(
    sequenceNumber: '123456789',
    driverId: '1234567890',
    tripId: 'TRIP_2025_001234',
    distanceInMeters: 5420,
    durationInSeconds: 1245,
    customerRating: 4.5,
    customerWaitingTimeInSeconds: 180,
    originCityNameInArabic: 'الرياض',
    destinationCityNameInArabic: 'الرياض',
    originLatitude: 24.723437,
    originLongitude: 46.117452,
    destinationLatitude: 24.763437,
    destinationLongitude: 46.547452,
    pickupTimestamp: '2025-12-07T14:30:00.000',
    dropoffTimestamp: '2025-12-07T14:50:45.000',
    startedWhen: '2025-12-07T14:25:00.000',
    tripCost: 35.50,
    driverArrivalTime: '2025-12-07T14:28:00.000',
    driverAssignTime: '2025-12-07T14:25:30.000'
);

$response = LaravelWasl::registerTrip($request);

if ($response->success) {
    echo "Trip registered successfully!";
}
```

### Update Trip(s)

Update a single trip or multiple trips (max 1000):

```php
use Habib\LaravelWasl\Facades\LaravelWasl;
use Habib\LaravelWasl\DTOs\TripUpdateRequest;

// Single trip update
$trip = new TripUpdateRequest(
    tripId: 'TRIP_2025_001234',
    customerRating: 5.0,
    tripCost: 35.50
);

$response = LaravelWasl::updateTrips($trip);

// Multiple trips update
$trips = [
    new TripUpdateRequest(
        tripId: 'TRIP_2025_001234',
        customerRating: 5.0,
        tripCost: 35.50
    ),
    new TripUpdateRequest(
        tripId: 'TRIP_2025_001235',
        customerRating: 4.0,
        tripCost: 28.00
    ),
];

$response = LaravelWasl::updateTrips($trips);

// Check for rejected trips
foreach ($response->rejectedTrips as $rejectedTrip) {
    echo "Trip {$rejectedTrip->tripId} rejected: {$rejectedTrip->rejectionReason}";
}
```

### Update Vehicle Location(s)

Update location for a single vehicle or multiple vehicles (max 1000):

```php
use Habib\LaravelWasl\Facades\LaravelWasl;
use Habib\LaravelWasl\DTOs\LocationUpdateRequest;

// Single location update
$location = new LocationUpdateRequest(
    driverIdentityNumber: '1234567890',
    vehicleSequenceNumber: '123456789',
    latitude: 24.723437,
    longitude: 46.117452,
    hasCustomer: true,
    updatedWhen: '2025-12-07T15:30:00.000'
);

$response = LaravelWasl::updateLocations($location);

// Multiple locations update
$locations = [
    new LocationUpdateRequest(
        driverIdentityNumber: '1234567890',
        vehicleSequenceNumber: '123456789',
        latitude: 24.723437,
        longitude: 46.117452,
        hasCustomer: true,
        updatedWhen: '2025-12-07T15:30:00.000'
    ),
    new LocationUpdateRequest(
        driverIdentityNumber: '1234567891',
        vehicleSequenceNumber: '123456780',
        latitude: 25.723437,
        longitude: 47.117452,
        hasCustomer: false,
        updatedWhen: '2025-12-07T15:30:00.000'
    ),
];

$response = LaravelWasl::updateLocations($locations);

// Check for failed vehicles
foreach ($response->failedVehicles as $failedVehicle) {
    echo "Failed: {$failedVehicle}";
}
```

## Error Handling

The package provides custom exceptions for different error scenarios:

```php
use Habib\LaravelWasl\Exceptions\WaslException;
use Habib\LaravelWasl\Exceptions\WaslNotFoundException;
use Habib\LaravelWasl\Exceptions\WaslBadRequestException;
use Habib\LaravelWasl\Exceptions\WaslUnauthorizedException;
use Habib\LaravelWasl\Exceptions\WaslServerException;

try {
    $response = LaravelWasl::registerDriver($request);
} catch (WaslNotFoundException $e) {
    // Driver or vehicle not found
    echo "Error: " . $e->getMessage();
    echo "Result Code: " . $e->resultCode;
} catch (WaslBadRequestException $e) {
    // Validation error or bad request
    echo "Error: " . $e->getMessage();
    echo "Result Message: " . $e->resultMsg;
} catch (WaslUnauthorizedException $e) {
    // Authentication failed
    echo "Authentication error: " . $e->getMessage();
} catch (WaslServerException $e) {
    // Server error
    echo "Server error: " . $e->getMessage();
} catch (WaslException $e) {
    // Other Wasl API errors
    echo "Error: " . $e->getMessage();
}
```

## Validation

The package includes built-in validation for all Wasl API fields:

### Plate Letter Validation

```php
use Habib\LaravelWasl\Rules\WaslPlateLetter;

// Use in Laravel form requests
$rules = [
    'plate_letter' => ['required', new WaslPlateLetter()],
];

// Or access allowed letters directly
$allowedLetters = WaslPlateLetter::ALLOWED_LETTERS;
// ['ا', 'ب', 'ح', 'د', 'ر', 'س', 'ص', 'ط', 'ع', 'ق', 'ك', 'ل', 'م', 'ن', 'هـ', 'و', 'ى']
```

### DTO Validation

All DTOs automatically validate their data when instantiated:

```php
use Habib\LaravelWasl\DTOs\DriverData;

try {
    $driver = new DriverData(
        identityNumber: '1234567890', // Must be exactly 10 digits
        emailAddress: 'driver@example.com', // Must be valid email
        mobileNumber: '+966512345678', // Must match +966XXXXXXXXX format
        dateOfBirthHijri: '1420/01/01' // Must be YYYY-MM-DD or YYYY/MM/DD
    );
} catch (\InvalidArgumentException $e) {
    echo "Validation error: " . $e->getMessage();
}
```

## Error Message Helper

Get human-readable descriptions for Wasl API error codes:

```php
use Habib\LaravelWasl\Helpers\WaslErrorMessageHelper;

// Get result code description
$description = WaslErrorMessageHelper::getResultCodeDescription('DRIVER_NOT_FOUND');
// Returns: "Driver information is not correct"

// Get rejection reason description
$reason = WaslErrorMessageHelper::getRejectionReasonDescription('DRIVER_LICENSE_EXPIRED');
// Returns: "Driver license is expired"

// Get criminal record status description
$status = WaslErrorMessageHelper::getCriminalRecordStatusDescription('PENDING_DRIVER_APPROVAL');
// Returns: "SMS sent to driver, waiting for approval on Absher"

// Get trip rejection reason (with Arabic support)
$englishReason = WaslErrorMessageHelper::getTripRejectionReason('duplicate trip id');
// Returns: "Trip ID is already registered"

$arabicReason = WaslErrorMessageHelper::getTripRejectionReason('duplicate trip id', arabic: true);
// Returns: "رقم الرحلة مسجل مسبقا"
```

## Enums

The package includes enums for type safety:

```php
use Habib\LaravelWasl\Enums\EligibilityStatus;
use Habib\LaravelWasl\Enums\Gender;
use Habib\LaravelWasl\Enums\PlateType;
use Habib\LaravelWasl\Enums\CriminalRecordStatus;

// EligibilityStatus: VALID, INVALID, PENDING
// Gender: MALE, FEMALE
// PlateType: PRIVATE_CAR, TAXI, TRUCK, BUS, MOTORCYCLE
// CriminalRecordStatus: WAITING, PENDING_DRIVER_APPROVAL, DRIVER_APPROVED, etc.
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Mohamed Habib](https://github.com/mohamedhabibwork)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
