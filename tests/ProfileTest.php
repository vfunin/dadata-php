<?php

namespace Dadata;

use DateTime;
use GuzzleHttp\Client;

final class ProfileTest extends BaseTest
{
    public function testGetBalance(): void
    {
        $response = ["balance" => 9922.30];
        $this->mockResponse($response);
        $actual = $this->api->getBalance();
        $this->assertEquals(9922.30, $actual);
    }

    public function testGetDailyStats(): void
    {
        $today = new DateTime();
        $todayStr = $today->format("Y-m-d");
        $expected = ["date" => $todayStr, "services" => ["merging" => 0, "suggestions" => 11, "clean" => 1004]];
        $this->mockResponse($expected);
        $actual = $this->api->getDailyStats();
        $this->assertEquals($expected, $actual);
    }

    public function testSecret(): void
    {
        $api = new ProfileClient((new Settings('123','456')));
        $headers = $api->client->getConfig("headers");
        $this->assertEquals("456", $headers["X-Secret"]);
    }

    public function testToken(): void
    {
        $api = new ProfileClient((new Settings('123','456')));
        $headers = $api->client->getConfig("headers");
        $this->assertEquals("Token 123", $headers["Authorization"]);
    }

    public function testVersions(): void
    {
        $expected = [
            "dadata"      => ["version" => "17.1 (5995:3d7b54a78838)"],
            "suggestions" => ["version" => "16.10 (5a2e47f29553)", "resources" => ["ЕГРЮЛ" => "13.01.2017"]],
            "factor"      => ["version" => "8.0 (90780)", "resources" => ["ФИАС" => "30.01.2017"]],
        ];
        $this->mockResponse($expected);
        $actual = $this->api->getVersions();
        $this->assertEquals($expected, $actual);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new ProfileClient((new Settings('token','secret')));
        $this->api->client = new Client(["handler" => $this->handler]);
    }
}
