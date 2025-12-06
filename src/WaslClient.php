<?php

declare(strict_types=1);

namespace Habib\LaravelWasl;

use Habib\LaravelWasl\Exceptions\WaslBadRequestException;
use Habib\LaravelWasl\Exceptions\WaslException;
use Habib\LaravelWasl\Exceptions\WaslNotFoundException;
use Habib\LaravelWasl\Exceptions\WaslServerException;
use Habib\LaravelWasl\Exceptions\WaslUnauthorizedException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

final class WaslClient
{
    private PendingRequest $client;

    public function __construct()
    {
        $environment = Config::get('wasl.wasl_env', 'live');
        $configPath = "wasl.{$environment}";

        $baseUrl = Config::get("{$configPath}.base_url");
        $timeout = Config::get("{$configPath}.timeout", 30);

        $this->client = Http::baseUrl($baseUrl)
            ->timeout($timeout)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'client-id' => Config::get("{$configPath}.client_id"),
                'app-id' => Config::get("{$configPath}.app_id"),
                'app-key' => Config::get("{$configPath}.app_key"),
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws WaslException
     */
    public function get(string $endpoint, array $data = []): array
    {
        $response = $this->client->get($endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws WaslException
     */
    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->client->post($endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws WaslException
     */
    public function patch(string $endpoint, array $data = []): array
    {
        $response = $this->client->patch($endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws WaslException
     */
    private function handleResponse(\Illuminate\Http\Client\Response $response): array
    {
        $statusCode = $response->status();
        $body = $response->json() ?? [];

        // Check if API returned success: false in the body (even with 200 status)
        if (isset($body['success']) && $body['success'] === false) {
            $resultCode = $body['resultCode'] ?? null;
            $resultMsg = $body['resultMsg'] ?? null;
            $message = $resultMsg ?? ($resultCode ?? 'Unknown error');

            // Map result codes to appropriate exceptions
            throw match ($resultCode) {
                'DRIVER_NOT_FOUND', 'VEHICLE_NOT_FOUND' => new WaslNotFoundException($message, 404, null, $resultCode, $resultMsg),
                'bad_request' => new WaslBadRequestException($message, 400, null, $resultCode, $resultMsg),
                default => new WaslException($message, $statusCode, null, $resultCode, $resultMsg),
            };
        }

        // Handle HTTP status code errors
        if (! $response->successful()) {
            $resultCode = $body['resultCode'] ?? null;
            $resultMsg = $body['resultMsg'] ?? null;
            $message = $resultMsg ?? $response->reason() ?? 'Unknown error';

            throw match (true) {
                $statusCode === 400 => new WaslBadRequestException($message, $statusCode, null, $resultCode, $resultMsg),
                $statusCode === 401 || $statusCode === 403 => new WaslUnauthorizedException($message, $statusCode, null, $resultCode, $resultMsg),
                $statusCode === 404 => new WaslNotFoundException($message, $statusCode, null, $resultCode, $resultMsg),
                $statusCode >= 500 => new WaslServerException($message, $statusCode, null, $resultCode, $resultMsg),
                default => new WaslException($message, $statusCode, null, $resultCode, $resultMsg),
            };
        }

        return $body;
    }
}
