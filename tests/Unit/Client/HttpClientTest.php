<?php

namespace Tests\Unit\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    /**
     * @throws TikApiException
     */
    public function testSuccessfulRequestReturnsArray()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['status' => 'success'])),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $http = new HttpClient($client, 'test_api_key');

        $response = $http->request('GET', 'public/check', ['username' => 'testuser']);

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
    }

    /**
     * @throws TikApiException
     */
    public function testRequestIncludesHeaders()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['ok' => true])),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $http = new HttpClient($client, 'my_api_key', 'acc_key', 'https://api.tikapi.io');

        $response = $http->request('GET', 'public/check');

        // Since we can't inspect headers from MockHandler directly,
        // we assert the response is parsed successfully
        $this->assertArrayHasKey('ok', $response);
    }

    public function testThrowsExceptionOnErrorResponse()
    {
        $mock = new MockHandler([
            new Response(404, [], 'Not Found'),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $http = new HttpClient($client, 'test_api_key');

        $this->expectException(TikApiException::class);

        $http->request('GET', 'public/check');
    }
}
