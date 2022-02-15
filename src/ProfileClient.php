<?php

declare(strict_types=1);

namespace Dadata;

use DateTime;
use DateTimeInterface;

class ProfileClient extends ClientBase
{
    const BASE_URL = "https://dadata.ru/api/v2/";

    public function __construct(Settings $settings)
    {
        parent::__construct(self::BASE_URL, $settings);
    }

    public function getBalance(): float
    {
        $url = "profile/balance";
        $response = $this->get($url);

        return $response["balance"];
    }

    public function getDailyStats(?DateTimeInterface $date = null): array
    {
        $url = "stat/daily";
        if (is_null($date)) {
            $date = new DateTime();
        }
        $query = ["date" => $date->format("Y-m-d")];

        return $this->get($url, $query);
    }

    public function getVersions(): array
    {
        $url = "version";

        return $this->get($url);
    }
}
