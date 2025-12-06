# Changelog

All notable changes to `laravel-wasl` will be documented in this file.

## [1.0.0] - 2025-12-07

### Added

- Complete Wasl API integration with all 6 endpoints:
  - Driver and Vehicle Registration (POST `/drivers`)
  - Bulk Driver Eligibility Check (POST `/drivers/eligibility`)
  - Single Driver Eligibility Check (GET `/drivers/eligibility/{identityNumber}`)
  - Trip Registration (POST `/trips`)
  - Trip Update (PATCH `/trips`) - supports single or multiple trips
  - Location Update (POST `/locations`) - supports single or multiple locations

- Type-safe DTOs (Data Transfer Objects) for all requests and responses:
  - `DriverRegistrationRequest` with nested `DriverData` and `VehicleData`
  - `DriverEligibilityBulkRequest` and `DriverEligibilityBulkResponse`
  - `DriverEligibilityResponse` with nested `VehicleEligibilityResponse`
  - `TripRegistrationRequest` and `TripRegistrationResponse`
  - `TripUpdateRequest` and `TripUpdateResponse` with `RejectedTripResponse`
  - `LocationUpdateRequest` and `LocationUpdateResponse`

- Custom exception classes for comprehensive error handling:
  - `WaslException` - Base exception class
  - `WaslNotFoundException` - For 404 errors and driver/vehicle not found
  - `WaslBadRequestException` - For 400 errors and validation failures
  - `WaslUnauthorizedException` - For 401/403 authentication errors
  - `WaslServerException` - For 500+ server errors

- Enum classes for type safety:
  - `EligibilityStatus` - VALID, INVALID, PENDING
  - `Gender` - MALE, FEMALE
  - `PlateType` - PRIVATE_CAR, TAXI, TRUCK, BUS, MOTORCYCLE
  - `CriminalRecordStatus` - All criminal record status values

- Validation rules and helpers:
  - `WaslPlateLetter` - Laravel validation rule for Arabic plate letters
  - `WaslErrorMessageHelper` - Helper class for error code meanings and descriptions
  - Comprehensive validation in all DTOs with clear error messages

- `WaslClient` - HTTP client wrapper using Laravel's HTTP facade
- `LaravelWasl` - Main service class with all endpoint methods
- Configuration file (`config/wasl.php`) with environment variable support (live/dev)
- Facade support via `LaravelWasl` facade
- Service provider with proper dependency injection

### Features

- Full support for PHP 8.3+ features (readonly properties, typed properties, enums)
- Strict typing throughout the codebase
- Array support for bulk operations (trips and locations)
- Comprehensive error handling with custom exceptions
- Built-in validation for all Wasl API fields:
  - Driver identity numbers (10 digits)
  - Mobile numbers (+966XXXXXXXXX format)
  - Email addresses
  - Plate letters (valid Arabic letters)
  - Vehicle sequence numbers (9 digits)
  - Plate numbers (1-4 digits)
  - Plate types (1-11)
  - Date formats (Hijri and Gregorian)
  - Coordinates (latitude/longitude ranges)
  - Trip ratings (0-5)
- Error message helper with all Wasl API error codes, rejection reasons, and status descriptions
- Support for Arabic error messages
- Clean architecture with one class per file
- Uses Laravel core HTTP client (no external dependencies)
- Proper validation in DTOs with detailed PHPDoc comments
- Factory methods (`fromArray()`) for response parsing

### Technical Details

- All classes use `readonly` properties where applicable
- Constructor property promotion for cleaner code
- Strict type declarations (`declare(strict_types=1)`)
- Proper exception handling with error codes and messages
- Support for both Saudi (Hijri) and Non-Saudi (Gregorian) date formats
- Handles API responses with `success: false` even with 200 status codes
- Proper mapping of API result codes to exceptions
- Environment-based configuration (live/dev) with separate credentials
- Validation rules follow Wasl API documentation exactly
