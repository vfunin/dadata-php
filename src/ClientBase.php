<?php

declare(strict_types=1);

namespace Dadata;

use GuzzleHttp\Client;

abstract class ClientBase
{
    public Client $client;
    private Settings $settings;

    public function __construct(string $baseUrl, Settings $settings)
    {
        $headers = [
            "Content-Type"  => $settings->getFormat(),
            "Accept"        => $settings->getFormat(),
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
        $this->settings = $settings;
    }

    protected function get(string $url, array $query = []): array
    {
        $response = $this->client->get($url, ["query" => $query]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param  string  $url
     * @param  array  $data
     *
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function post(string $url, array $data)
    {
        $response = $this->client->post($url, [
            $this->settings->isJSON() ? 'json' : 'body' => $this->settings->isJSON() ? $data : $data[0],
        ]);

        $content = $response->getBody()->getContents();
        return $this->settings->isJSON() ? json_decode($content, true) : $content;
    }
}
