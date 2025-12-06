<?php

declare(strict_types=1);

namespace Habib\LaravelWasl;

use Habib\LaravelWasl\DTOs\DriverEligibilityBulkRequest;
use Habib\LaravelWasl\DTOs\DriverEligibilityBulkResponse;
use Habib\LaravelWasl\DTOs\DriverEligibilityResponse;
use Habib\LaravelWasl\DTOs\DriverRegistrationRequest;
use Habib\LaravelWasl\DTOs\DriverRegistrationResponse;
use Habib\LaravelWasl\DTOs\LocationUpdateRequest;
use Habib\LaravelWasl\DTOs\LocationUpdateResponse;
use Habib\LaravelWasl\DTOs\TripRegistrationRequest;
use Habib\LaravelWasl\DTOs\TripRegistrationResponse;
use Habib\LaravelWasl\DTOs\TripUpdateRequest;
use Habib\LaravelWasl\DTOs\TripUpdateResponse;

final class LaravelWasl
{
    public function __construct(
        private readonly WaslClient $client,
    ) {}

    /**
     * Register a driver and vehicle
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function registerDriver(DriverRegistrationRequest $request): DriverRegistrationResponse
    {
        $response = $this->client->post('/drivers', $request->toArray());

        if (! isset($response['result'])) {
            throw new \RuntimeException('Invalid response format from Wasl API');
        }

        return DriverRegistrationResponse::fromArray($response['result']);
    }

    /**
     * Check eligibility for multiple drivers (bulk)
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function checkEligibilityBulk(DriverEligibilityBulkRequest $request): DriverEligibilityBulkResponse
    {
        $response = $this->client->post('/drivers/eligibility', $request->toArray());

        if (! is_array($response)) {
            throw new \RuntimeException('Invalid response format from Wasl API');
        }

        return DriverEligibilityBulkResponse::fromArray($response);
    }

    /**
     * Check eligibility for a specific driver
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function checkEligibility(string $identityNumber): DriverEligibilityResponse
    {
        $response = $this->client->get("/drivers/eligibility/{$identityNumber}");

        return DriverEligibilityResponse::fromArray($response);
    }

    /**
     * Register a trip
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function registerTrip(TripRegistrationRequest $request): TripRegistrationResponse
    {
        $response = $this->client->post('/trips', $request->toArray());

        return TripRegistrationResponse::fromArray($response);
    }

    /**
     * Update one or more trips
     *
     * @param  TripUpdateRequest|array<TripUpdateRequest>  $request
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function updateTrips(TripUpdateRequest|array $request): TripUpdateResponse
    {
        $trips = is_array($request) ? $request : [$request];
        $data = TripUpdateRequest::toBulkArray($trips);

        $response = $this->client->patch('/trips', $data);

        return TripUpdateResponse::fromArray($response);
    }

    /**
     * Update one or more vehicle locations
     *
     * @param  LocationUpdateRequest|array<LocationUpdateRequest>  $request
     *
     * @throws \Habib\LaravelWasl\Exceptions\WaslException
     */
    public function updateLocations(LocationUpdateRequest|array $request): LocationUpdateResponse
    {
        $locations = is_array($request) ? $request : [$request];
        $data = LocationUpdateRequest::toBulkArray($locations);

        $response = $this->client->post('/locations', $data);

        return LocationUpdateResponse::fromArray($response);
    }
}
