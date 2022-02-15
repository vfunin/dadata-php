<?php

declare(strict_types=1);

namespace Dadata;

class DadataClient
{
    private CleanClient $cleaner;
    private ProfileClient $profile;
    private SuggestClient $suggestions;

    public function __construct(string $token, ?string $secret = null, array $options = [])
    {
        $settings = new Settings($token, $secret, $options);
        $this->cleaner = new CleanClient($settings);
        $this->profile = new ProfileClient($settings);
        $this->suggestions = new SuggestClient($settings);
    }

    public function clean($name, $value): array
    {
        return $this->cleaner->clean($name, $value);
    }

    public function cleanRecord($structure, $record): array
    {
        return $this->cleaner->cleanRecord($structure, $record);
    }

    public function findAffiliated($query, $count = Settings::SUGGESTION_COUNT, $kwargs = []): array
    {
        return $this->suggestions->findAffiliated($query, $count, $kwargs);
    }

    public function findById($name, $query, $count = Settings::SUGGESTION_COUNT, $kwargs = []): array
    {
        return $this->suggestions->findById($name, $query, $count, $kwargs);
    }

    public function geolocate(
        $name,
        $lat,
        $lon,
        $radiusMeters = 100,
        $count = Settings::SUGGESTION_COUNT,
        $kwargs = []
    ): array {
        return $this->suggestions->geolocate($name, $lat, $lon, $radiusMeters, $count, $kwargs);
    }

    public function getBalance(): float
    {
        return $this->profile->getBalance();
    }

    public function getDailyStats($date = null): array
    {
        return $this->profile->getDailyStats($date);
    }

    public function getVersions(): array
    {
        return $this->profile->getVersions();
    }

    public function iplocate($ip, $kwargs = [])
    {
        return $this->suggestions->iplocate($ip, $kwargs);
    }

    public function suggest($name, $query, $count = Settings::SUGGESTION_COUNT, $kwargs = [])
    {
        return $this->suggestions->suggest($name, $query, $count, $kwargs);
    }
}
