<?php

namespace Tests\Feature\Public;

use GuzzleHttp\Client as Guzzle;
use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\TikApi;
use PHPUnit\Framework\TestCase;

class MusicInfoIntegrationTest extends TestCase
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

    public function testPublicMusicInfoEndpointReturnsSuccess()
    {
        $musicId = '7403687527420906257'; // Example TikTok music ID

        $response = $this->tikapi->public()->musicInfo()->get($musicId, 'us');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', strtolower($response['status']));
    }
}
