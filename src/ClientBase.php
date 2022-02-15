<?php

declare(strict_types=1);

namespace Dadata;

use GuzzleHttp\Client;

abstract class ClientBase
{
    public Client $client;

    public function __construct(string $baseUrl, Settings $settings)
    {
        $headers = [
            "Content-Type"  => "application/json",
            "Accept"        => "application/json",
            "Authorization" => "Token ".$settings->getToken(),
        ];
        if ($settings->getSecret()) {
            $headers["X-Secret"] = $settings->getSecret();
        }
        $this->client = new Client(
            array_merge($settings->getOptions(), [
                "base_uri" => $baseUrl,
                "headers"  => $headers,
                "timeout"  => Settings::TIMEOUT_SEC,
            ])
        );
    }

    protected function get(string $url, array $query = []): array
    {
        $response = $this->client->get($url, ["query" => $query]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function post(string $url, array $data): array
    {
        $response = $this->client->post($url, [
            "json" => $data,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
