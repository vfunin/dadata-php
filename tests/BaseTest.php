<?php

namespace Dadata;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected ClientBase $api;
    protected HandlerStack $handler;
    protected array $history;
    protected MockHandler $mock;

    protected function getLastRequest()
    {
        $request = $this->history[count($this->history) - 1]["request"];
        $body = $request->getBody();
        $body->rewind();

        return json_decode($body->getContents(), true);
    }

    protected function mockResponse($data)
    {
        $body = Psr7\Utils::streamFor(json_encode($data));
        $response = new Response(200, [], $body);
        $this->mock->append($response);
    }

    protected function setUp(): void
    {
        $this->mock = new MockHandler();
        $this->handler = HandlerStack::create($this->mock);
        $this->history = [];
        $history = Middleware::history($this->history);
        $this->handler->push($history);
    }
}
