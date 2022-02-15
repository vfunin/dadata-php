<?php

declare(strict_types=1);

namespace Dadata;

class CleanClient extends ClientBase
{
    const BASE_URL = "https://cleaner.dadata.ru/api/v1/";

    public function __construct(Settings $settings)
    {
        parent::__construct(self::BASE_URL, $settings);
    }

    public function clean(string $name, string $value): array
    {
        $url = "clean/$name";
        $fields = [$value];
        $response = $this->post($url, $fields);

        return $response[0];
    }

    public function cleanRecord(array $structure, array $record): array
    {
        $url = "clean";
        $data = [
            "structure" => $structure,
            "data"      => [$record],
        ];
        $response = $this->post($url, $data);

        return $response["data"][0];
    }
}
