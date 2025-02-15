<?php

namespace Dadata;

use GuzzleHttp\Client;

final class SuggestTest extends BaseTest
{
    public function testFindAffiliated(): void
    {
        $expected = [
            ["value" => "ООО ДЗЕН.ПЛАТФОРМА", "data" => ["inn" => "7704431373"]],
            ["value" => "ООО ЕДАДИЛ", "data" => ["inn" => "7728237907"]],
        ];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->findAffiliated("7736207543");
        $this->assertEquals($expected, $actual);
    }

    public function testFindAffiliatedNotFound(): void
    {
        $expected = [];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->findAffiliated("1234567890");
        $this->assertEquals($expected, $actual);
    }

    public function testFindAffiliatedRequest(): void
    {
        $this->mockResponse(['suggestions' => ["query" => "7736207543", "count" => 5]]);
        $this->api->findAffiliated("7736207543", 5);
        $expected = ["query" => "7736207543", "count" => 5];
        $actual = $this->getLastRequest();
        $this->assertEquals($expected, $actual);
    }

    public function testFindById(): void
    {
        $expected = [
            ["value" => "ООО МОТОРИКА", "data" => ["inn" => "7719402047"]],
        ];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->findById("party", "7719402047");
        $this->assertEquals($expected, $actual);
    }

    public function testFindByIdNotFound(): void
    {
        $expected = [];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->findById("party", "1234567890");
        $this->assertEquals($expected, $actual);
    }

    public function testFindByIdRequest(): void
    {
        $this->mockResponse(['suggestions' => ["query" => "7719402047", "count" => 5, "kpp" => "773101001"]]);
        $kwargs = [
            "kpp" => "773101001",
        ];
        $this->api->findById("party", "7719402047", 5, $kwargs);
        $expected = ["query" => "7719402047", "count" => 5, "kpp" => "773101001"];
        $actual = $this->getLastRequest();
        $this->assertEquals($expected, $actual);
    }

    public function testGeolocate(): void
    {
        $expected = [
            [
                "value" => "г Москва, ул Сухонская, д 11",
                "data"  => ["kladr_id" => "7700000000028360004"],
            ],
        ];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->geolocate("address", 55.8782557, 37.65372);
        $this->assertEquals($expected, $actual);
    }

    public function testGeolocateNotFound(): void
    {
        $expected = [];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->geolocate("address", 1, 1);
        $this->assertEquals($expected, $actual);
    }

    public function testGeolocateRequest(): void
    {
        $this->mockResponse(
            ['suggestions' => ["lat" => 55.8782557, "lon" => 37.65372, "radius_meters" => 200, "count" => 5]]
        );
        $this->api->geolocate("address", 55.8782557, 37.65372, 200, 5);
        $expected = ["lat" => 55.8782557, "lon" => 37.65372, "radius_meters" => 200, "count" => 5];
        $actual = $this->getLastRequest();
        $this->assertEquals($expected, $actual);
    }

    public function testIplocate(): void
    {
        $expected = [
            "value" => "г Москва",
            "data"  => ["kladr_id" => "7700000000000"],
        ];
        $response = [
            "location" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->iplocate("212.45.30.108");
        $this->assertEquals($expected, $actual);
    }

    public function testIplocateNotFound(): void
    {
        $response = [
            "location" => null,
        ];
        $this->mockResponse($response);
        $actual = $this->api->iplocate("212.45.30.108");
        $this->assertNull($actual);
    }

    public function testSuggest(): void
    {
        $expected = [
            ["value" => "г Москва, ул Сухонская", "data" => ["kladr_id" => "77000000000283600"]],
            ["value" => "г Москва, ул Сухонская, д 1", "data" => ["kladr_id" => "7700000000028360009"]],
        ];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->suggest("address", "мск сухонская");
        $this->assertEquals($expected, $actual);
    }

    public function testSuggestNotFound(): void
    {
        $expected = [];
        $response = [
            "suggestions" => $expected,
        ];
        $this->mockResponse($response);
        $actual = $this->api->suggest("address", "whatever");
        $this->assertEquals($expected, $actual);
    }

    public function testSuggestRequest(): void
    {
        $this->mockResponse(['suggestions' => ["query" => "samara", "count" => 10, "to_bound" => ["value" => "city"]]]);
        $kwargs = [
            "to_bound" => ["value" => "city"],
        ];
        $this->api->suggest("address", "samara", 10, $kwargs);
        $expected = ["query" => "samara", "count" => 10, "to_bound" => ["value" => "city"]];
        $actual = $this->getLastRequest();
        $this->assertEquals($expected, $actual);
    }

    public function testToken(): void
    {
        $api = new SuggestClient((new Settings('123')));
        $headers = $api->client->getConfig("headers");
        $this->assertEquals("Token 123", $headers["Authorization"]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new SuggestClient((new Settings('token')));
        $this->api->client = new Client(["handler" => $this->handler]);
    }
}
