<?php

declare(strict_types=1);

namespace Dadata;

class SuggestClient extends ClientBase
{
    const BASE_URL = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/";

    public function __construct(Settings $settings)
    {
        parent::__construct(self::BASE_URL, $settings);
    }

    public function findAffiliated(string $query, int $count = Settings::SUGGESTION_COUNT, array $kwargs = []): array
    {
        $url = "findAffiliated/party";
        $data = ["query" => $query, "count" => $count];
        $data = $data + $kwargs;
        $response = $this->post($url, $data);

        return $response["suggestions"];
    }

    public function findById(
        string $name,
        string $query,
        int $count = Settings::SUGGESTION_COUNT,
        array $kwargs = []
    ): array {
        $url = "findById/$name";
        $data = ["query" => $query, "count" => $count];
        $data = $data + $kwargs;
        $response = $this->post($url, $data);

        return $response["suggestions"];
    }

    public function geolocate(
        string $name,
        string $lat,
        string $lon,
        int $radiusMeters = 100,
        int $count = Settings::SUGGESTION_COUNT,
        array $kwargs = []
    ): array {
        $url = "geolocate/$name";
        $data = [
            "lat"           => $lat,
            "lon"           => $lon,
            "radius_meters" => $radiusMeters,
            "count"         => $count,
        ];
        $data = $data + $kwargs;
        $response = $this->post($url, $data);

        return $response["suggestions"];
    }

    public function iplocate(string $ip, array $kwargs = []): ?array
    {
        $url = "iplocate/address";
        $query = ["ip" => $ip];
        $query = $query + $kwargs;
        $response = $this->get($url, $query);

        return $response["location"];
    }

    public function suggest(
        string $name,
        string $query,
        int $count = Settings::SUGGESTION_COUNT,
        array $kwargs = []
    ): array {
        $url = "suggest/$name";
        $data = ["query" => $query, "count" => $count];
        $data = $data + $kwargs;
        $response = $this->post($url, $data);

        return $response["suggestions"];
    }
}
