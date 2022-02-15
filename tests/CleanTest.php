<?php

namespace Dadata;

use GuzzleHttp\Client;

final class CleanTest extends BaseTest
{
    public function testClean(): void
    {
        $expected = [
            "source" => "Сережа",
            "result" => "Сергей",
            "qc"     => 1,
        ];
        $this->mockResponse([$expected]);
        $actual = $this->api->clean("name", "Сережа");
        $this->assertEquals($expected, $actual);
    }

    public function testCleanRecord(): void
    {
        $structure = ["AS_IS", "AS_IS", "AS_IS"];
        $record = ["1", "2", "3"];
        $expected = [
            [
                "source" => "1",
            ],
            [
                "source" => "2",
            ],
            [
                "source" => "3",
            ],
        ];
        $response = [
            "structure" => $structure,
            "data"      => [$expected],
        ];
        $this->mockResponse($response);
        $actual = $this->api->cleanRecord($structure, $record);
        $this->assertEquals($actual, $expected);
    }

    public function testCleanRequest(): void
    {
        $expected = ["москва"];
        $this->mockResponse([$expected]);
        $this->api->clean("address", "москва");
        $actual = $this->getLastRequest();
        $this->assertEquals($expected, $actual);
    }

    public function testSecret(): void
    {
        $api = new CleanClient((new Settings('123','456')));
        $headers = $api->client->getConfig("headers");
        $this->assertEquals("456", $headers["X-Secret"]);
    }

    public function testToken(): void
    {
        $api = new CleanClient((new Settings('123','456')));
        $headers = $api->client->getConfig("headers");
        $this->assertEquals("Token 123", $headers["Authorization"]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new CleanClient((new Settings('token','secret')));
        $this->api->client = new Client(["handler" => $this->handler]);
    }
}
