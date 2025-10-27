<?php

namespace Tests\Feature\Public;

use GuzzleHttp\Client as Guzzle;
use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\TikApi;
use PHPUnit\Framework\TestCase;

class CommentsIntegrationTest extends TestCase
{
    protected TikApi $tikapi;

    protected function setUp(): void
    {
        parent::setUp();

        $apiKey = $_ENV['TIKAPI_API_KEY'] ?? null;

        if (!$apiKey) {
            $this->markTestSkipped('No TIKAPI_API_KEY set in .env for integration test.');
        }

        $http = new HttpClient(new Guzzle(), $apiKey);
        $this->tikapi = new TikApi($apiKey);
    }

    public function testPublicCommentsEndpointReturnsSuccess()
    {
        $mediaId = '7109178205151464746';

        $response = $this->tikapi->public()->comments()->list($mediaId, 5, null, 'us');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', strtolower($response['status']));
        $this->assertArrayHasKey('comments', $response);
    }
}
